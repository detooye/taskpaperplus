/**
 * Main starting point
 */
$(document).ready(function () {

    "use strict";

    app.init();
    app.show('view');
    app.add_events();
    app.make_editable();
    app.sortable_tasks();
    app.sortable_projects();
    app.set_notes();
    app.loaded();
});



var app = (function () {

    "use strict";

    var pub = {};                 // all public methods


    var ajax_file = 'index.php',  // name of php ajax target file
        $view_tasks,
        $edit_tasks,
        $task_list,
        $text_area,
        $body,
        $index_load,
        $search_box,
        lang            = {},     // language strings for app use
        task_button_tpl = '',     // template for task line buttons
        task_prefix     = '',     // used to recognise a task in the search box
        page_address    = '',     // current (deep link) page address
        restricted      = false,  // restricted = trash or archive
        debug_mode      = false,  // is debug mode on?
        is_index        = true,   // initial index page load (i.e. not ajax)
        $insert_pos,
        $note_state;


    pub.init = function () {

        $view_tasks     = $("#view-tasks");
        $edit_tasks     = $("#edit-tasks");
        $task_list      = $('#task-list');
        $text_area      = $("#edit-tasks>textarea");
        $body           = $('body');
        $search_box     = $("#search-box");

        lang            = JSON.parse($("#jslang").html());

        task_button_tpl = $('#task-buttons-tpl').val();
        task_prefix     = $('#task-prefix').val();
        debug_mode      = $('#debug-mode').val() === '1';
        $insert_pos     = $('#insert_pos');
        $note_state      = $('#note_state');

        pub.toggle_insert();
        pub.set_notes();

        // set initial page address correctly (deep link after the #)
        page_address    = $("#page-address").val();
        $.address.value(page_address);

        // allow use of tab key in all textareas, makes it easier to add notes
        $.fn.tabOverride.tabSize(4);
        $(document).tabOverride(true, "textarea");

        // debug mode toggle message (double-click version number)
        lang['debug_msg'] = 'Do you want to toggle debug mode?';
        if (debug_mode === true) {
            $('.version')
                .css({'border-bottom': '2px solid red'})
                .css({'color': 'red'})
                .prepend("DEVELOPMENT  ");
        }
    };

    pub.loaded = function () {
        is_index = false;
    };

    /**
     * Prepare and make the PHP ajax request
     * you can provide a callback if request was successful:
     * e.g. for clean-up or result messages
     */
    var request = function (data, callback) {

        if (is_index) return;

        // set POST based on draft or size of value!
        var has_draft = typeof (data.draft) !== "undefined",
            long_value = typeof (data.value) !== "undefined" && data.value.length > 200,
            post = has_draft || long_value;

        callback = callback || false;

        throbber_on();

        if (post === true) {
            $.post(ajax_file,
                data,
                function (response) {
                    var success = render(response);
                    if (success && callback !== false) {
                        callback();
                    }
                }, 'json');
        } else {
            $.getJSON(ajax_file,
                data,
                function (response) {
                    var success = render(response);
                    if (success && callback !== false) {
                        callback();
                    }
                });
        }
    };


    /**
     * Generic ajax response function
     * renders any returned response data and updates address where necessary
     */
    var render = function (response) {

        throbber_off();

        if (response.type === 'done') {
            return true;
        }
        if (response !== undefined &&
            response !== null &&
            response.type !== 'error' &&
            response.type !== 'missing') {

            restricted = response.restricted;
            update_view(response);

            if (response.type === 'address' &&
                response.address !== '' &&
                $.address.value() !== response.address) {
                $.address.value(response.address);
            }
            return true;
        } else {
            return false;
        }
    };


    pub.show = function (which) {
        if (which === 'view') {
            $edit_tasks.hide();
            $view_tasks.show();
        } else if (which === 'edit') {
            $edit_tasks.show();
            $view_tasks.hide();
        }
    };


    pub.sortable_tasks = function () {
        // 'sortable' function needs to be added on each refresh
        if ($task_list.children(".sortable").length) {
            $task_list.children(".sortable").sortable({
                handle: ".drag-handle",
                update: function (action, ui) {
                    var order = $(this).sortable('toArray');
                    request({action: 'sort_tasks', value: order});
                }
            });
            $("#is-sortable").show();
        } else {
            $("#is-sortable").hide();
        }
    };


    pub.sortable_projects = function () {
        $('#projects').children(".sortable").sortable({
            items: "li:not(.not-sortable)",
            handle: ".drag-handle",
            update: function (action, ui) {
                var order = $(this).sortable('toArray');
                request({action: 'sort_projects', value: order});
            }
        });
    };


    pub.make_editable = function () {
        $('li.editable').editable(function (value) {
                var $that = $(this);
                request({action: 'editable', key: $that.attr("id"), value: value}, function () {
                    show_message(lang.edit_msg);
                    // no need to rest the editable function as this is done
                    // by the render function later
                });
            },
            {
                type:      'textarea',
                indicator: 'css/img/indicator.gif',
                event:     'dblclick',
                onblur:    'ignore',
                cssclass:  'editable-box',
                cols:      40,
                rows:      3,
                submit:    '<img class="top" src="images/save.png" title="' + lang.save_tip + '">',
                cancel:    '<img class="bottom" src="images/cancel.png" title="' + lang.cancel_tip + '">',
                data:     function () {
                    // the raw text is stored in the name attribute
                    var text = $(this).attr("name");
                    return text;
                },
                onedit:   function () {
                    // prevent mulitple edit instances!
                    $('li.editable').editable('disable');
                    // get rid of the floating toolbar
                    hide_task_button_tpl();
                    var $form = $(this).children('form');
                    var $edit_area = $form.children('textarea');
                    $edit_area.bind('keydown', 'ctrl+return meta+return', function () {
                        $form.trigger('submit');
                    });
                    var txt = $edit_area[0];
                    txt.selectionStart = txt.selectionEnd = txt.value.length;
                },
                onreset:    function () {
                    // return the editable function on reset
                    $('li.editable').editable('enable');
                }
            });
    };


    pub.set_notes = function() {
        var note_state = $note_state.val();
        if (note_state === 'max') {
            $(".reveal").hide();
            $(".hidden-note").show();
            $("#note-state img#max").hide();
            $("#note-state img#min").show();
        } else if (note_state === 'min') {
            $(".reveal").show();
            $(".hidden-note").hide();
            $("#note-state img#max").show();
            $("#note-state img#min").hide();
        }
    };


    /*
     * refreshes various parts of the view based on JSON data
     * returned to render function
     */
    var update_view = function (response) {

        // show edit area if necessary
        if (response.type === 'edit') {
            pub.show('edit');
            $text_area.val(response.text);
        } else {
            pub.show('view');
        }

        // update the page content where necessary

        if (response.tasks !== undefined) {
            $task_list.html(response.tasks);
            pub.sortable_tasks();
            pub.make_editable();
            pub.set_notes();
        }
        if (response.projects !== undefined) {
            $("#projects").html(response.projects);
            pub.sortable_projects();
        }
        if (response.tags !== undefined) {
            $("#tags").html(response.tags);
        }
        if (response.tabs !== undefined) {
            $("#tabs").html(response.tabs);
        }
        if (response.tabtools !== undefined) {
            $("#tabtools").html(response.tabtools);
        }
        if (restricted === true) {
            $(".restrict").prop("disabled", true);
        } else {
            $(".restrict").prop("disabled", false);
        }
    };


    var show_message = function (message) {

        var text = message[0],
            colour = message[1],
            new_top = ($(window).scrollTop() - 20) + "px",
            $message_banner = $("#message-banner");

        $("#message-banner span").text(text);
        var left = ($(window).width() - $message_banner.width()) / 2;

        $message_banner
            .removeClass()
            .addClass('bk-' + colour)
            .css({"top" : new_top, "left" : left})
            .animate({top: "+=20px", opacity: 200}, {duration: 900})
            .animate({opacity: 0}, {duration: 900});
    };


    var throbber_on = function () {
        $("#indicator").show();
    };

    var throbber_off = function () {
        $("#indicator").hide();
    };


    pub.toggle_insert = function () {
        if ($insert_pos.val() === 'top') {
            $("#insert img#top").show();
            $("#insert img#bottom").hide();
        } else {
            $("#insert img#top").hide();
            $("#insert img#bottom").show();
        }
    };


    var hide_task_button_tpl = function (target) {
        if (target === undefined) {
            $(".task-buttons").remove();
        } else {
            $(target).children(".task-buttons").remove();
        }
    };


    String.prototype.count = function (delim) {
        return this.split(delim).length - 1;
    };


    pub.add_events = function () {

        $('input, textarea').placeholder();

        $(".logo").on("click", "a", function() {
            request({action: 'all'});
        });

        $(".version")
            // toggle debug-mode
            .on("dblclick", "span", function(e) {
                if (e.shiftKey) {
                    var result = confirm(lang.debug_msg);
                    if (result) {
                        request({action: 'toggle_debug'});
                        window.setTimeout("window.location.reload()", 1000);
                        $index_load.val('false');
                    }
                }
            })
            .on("dblclick", "#purge-session", function () {
                request({action: 'purgesession'}, function() {
                    show_message(['Session cleared! Reloading...', 'green']);
                    window.setTimeout("window.location.reload()", 1500);
                    $index_load.val('false');
                });
            })
            .on("dblclick", "#purge-cache", function () {
                request({action: 'purgecache'}, function() {
                    show_message(['Cache cleared!', 'yellow']);
                });
            });

        $("#footer")
            .on("click", "#logout", function() {
                request({action: "logout"}, function() {
                    window.setTimeout("window.location.reload()", 1000);
                });
            })
            .on("change", "select", function () {
                request({action: 'lang', value: this.value}, function () {
                    show_message([lang.lang_change_msg, 'green']);
                    window.setTimeout("window.location.reload()", 1000);
                });
            });

        $("#indicators")
            .on("click", "#insert", function() {
                request({action: 'toggle_insert'}, function() {
                    var pos = $insert_pos.val();
                    $insert_pos.val(pos === 'top' ? 'bottom' : 'top');
                    pub.toggle_insert();
                });
            })
            .on("click", "#note-state", function() {
                request({action: 'toggle_notes'}, function() {
                    var pos = $note_state.val();
                    $note_state.val(pos === 'max' ? 'min' : 'max');
                    pub.set_notes();
                });
            });


        // Search Box

        $body.bind('keydown', 'shift+return', function (e) {
            e.preventDefault();
            $search_box.focus();
        });

        var show_reset_search = function () {
            $search_box.data('can_reset', true);
            $("#reset-search").show();
        };

        var reset_search = function () {
            if ($search_box.data('can_reset') === true) {
                $search_box.val('');
                $search_box.trigger('blur');
                $search_box.focus();
            }
        };

        $("#reset-search").on("click", function () {
            reset_search();
        });


        var add_task = function () {
            var expression = $search_box.val();
            if (expression !== '') {
                /* // add the task prefix if missing
                 if (expression.charAt(0) !== task_prefix) {
                 expression = task_prefix + " " + expression;
                 } */
                // new task to be added
                request({action: 'add', value: expression}, function () {
                    show_message(lang.add_msg);
                    $search_box.removeClass("big");
                    reset_search();
                });
            } else {
                reset_search();
            }
        };

        var do_search = function () {
            var expression = $search_box.val();
            if (expression !== "") {
                request({action: 'search', value: expression});
                // enter in a blank box == reset (common practice)
            } else {
                request({action: 'all'});
            }
        };

        $search_box
            .bind('keydown', 'ctrl+return meta+return', add_task)
            .bind('keydown', 'esc', reset_search)
            .bind('keydown', 'return', function (e) {
                var val = $(this).val();
                // check for a task entry (always "- " at beginning) or
                // in "big" text box mode and allow returns (assume task is being entered
                if (val.substr(0, 2) === (task_prefix + " ") || $(this).hasClass("big")) {
                    return;
                    // ignore empty returns
                } else if (val === '') {
                    reset_search();
                } else {
                    e.preventDefault();
                    do_search();
                }
            })
            // increase box size if this is a task entry
            .on("keyup", function () {
                if ($(this).val() === task_prefix) {
                    $(this).addClass("big");
                }
            })
            .on("dblclick", function() {
                $(this).toggleClass("big");
            })
            .on("click", function () {
                show_reset_search();
            })
            .on("focus", function () {
                show_reset_search();
            })
            .on("blur", function () {
                if ($(this).val() === '') {
                    $("#reset-search").hide();
                    $search_box.data('can_reset', false);
                }
                $(this).removeClass("big");
            });


        // Tab toolbar

        var save_edits = function () {
            request({action: 'save', value: $text_area.val()});
            $text_area
                .unbind('keydown', 'ctrl+return meta+return', save_edits)
                .unbind('keydown', 'esc', reset);
        };
        $("#edit-button").on("click", function () {
            request({action: 'edit'}, function () {
                $text_area
                    .bind('keydown', 'ctrl+return meta+return', save_edits)
                    .bind('keydown', 'esc', reset);
            });
        });
        $("#remove-actions-button").on("click", function () {
            request({action: 'remove_actions'});
        });
        $("#archive-done-button").on("click", function () {
            request({action: 'archive_done'}, function () {
                show_message(lang.arch_done_msg);
            });
        });
        $("#trash-done-button").on("click", function () {
            request({action: 'trash_done'}, function () {
                show_message(lang.trash_done_msg);
            });
        });
        $("#rename-button").on("click", function () {
            var new_name = prompt(lang.rename_msg);
            if (new_name !== null && new_name !== "") {
                request({action: 'rename', value: new_name});
            }
        });
        $("#remove-button").on("click", function () {
            var result = confirm(lang.remove_msg);
            if (result === true) {
                request({action: 'remove'});
            }
        });


        // Inside Text Edit box

        var reset = function () {
            request({action: 'all'});
        };

        $edit_tasks

            .on("click", "input.cancel-button", reset)

            // this is the 'Save' button, for editing area
            .on("click", "input.save-button", save_edits)

            // replace text in edited page
            .on("click", "#replace-button", function () {
                var find_text = $("#find-word").val();
                var replace_text = $("#replace-word").val();
                if (find_text !== "" && replace_text !== "") {
                    find_text = new RegExp(find_text, "gi");
                    var edit_text = $text_area.val();
                    edit_text = edit_text.replace(find_text, replace_text);
                    $text_area.val(edit_text);
                }
            });


        // Tab switching

        $("#tabs").on("click", "li", function (e) {
            e.preventDefault();
            var draft = '',
                tab = $(this).attr("name");

            // pass the draft text state if the edit area is visible
            if ($edit_tasks.css("display") !== "none") {
                draft = $text_area.val();
            }
            // the '+' tab (add new tab) is called __new__ behind the scenes...
            if (tab === '__new__') {
                var new_name = '';
                new_name = prompt(lang.create_msg);
                if (new_name !== null && new_name !== "") {
                    request({action: 'tab', value: new_name, draft: draft}, function () {
                        $text_area.focus();
                    });
                }
                // standard tab change
            } else {
                request({action: 'tab', value: tab, draft: draft});
            }
        });



        var show_project = function (target) {
            request({action: 'project', value: $(target).attr("data-index")});
        };

        $(".projects").on("click", "li", function () {
            show_project(this);
        });

        var show_tag = function (target) {
            request({action: 'tag', value: target.innerHTML});
        };

        // filter list in meta column
        $(".meta")
            .on("click", ".filters li span", function () {
                request({action: 'filter', value: $(this).attr("id")});
            })
            .on("click", "li .tag", function () {
                show_tag(this);
            });


        // all events in the main task list area

        $task_list
            // add or remove the task buttons
            .on("mouseenter", "li.task", function () {
                var $me = $(this);
                if ($me.has("form").length !== 0) {
                    return;
                }
                var tpl = task_button_tpl.replace(/\{id\}/gm, $me.attr("id"));
                $(tpl).appendTo($me);
            })
            .on("mouseleave", "li.task", function () {
                hide_task_button_tpl(this);
            })


            // all the task buttons
            .on("click", "li .check-done", function () {
                request({action: 'done', value: $(this).attr("id")});
            })
            .on("click", "li .action-button", function () {
                var $me = $(this);
                request({action: 'action', key: $me.attr("id"), value: $me.attr("data-action")});
            })
            .on("click", "li .archive-button", function () {
                request({action: 'archive', value: $(this).attr("id")}, function () {
                    show_message(lang.arch_msg);
                });
            })
            .on("click", "li .trash-button", function () {
                request({action: 'trash', value: $(this).attr("id")}, function () {
                    show_message(lang.trash_msg);
                });
            })


            // tags
            .on("click", ".tag, .date-tag", function () {
                show_tag(this);
            })


            // show or hide notes
            .on("click", ".reveal", function () {
                $(this).hide().prev().show();
            })
            .on("click", ".hidden-note", function () {
                $(this).next().show();
                $(this).hide();
            })


            // show a project
            .on("click", "li.project>p, li .project", function () {
                show_project(this);
            });


        $.address.externalChange(function (e) {
            var address = e.pathNames,
                tab = address[0];
            // ignore page load events or invalid addresses (i.e. at least tab must be provided)
            if (is_index === 'false' && tab !== undefined) {
                request({action: 'url', value: address});
            }
        });


        /* TOOLTIPS */

        $task_list
            .on("hover", "li.task>p", function () {
                $(this).attr("title", lang.edit_in_place_tip);
            })
            .on("hover", "li textarea", function () {
                $(this).attr("title", lang.editable_tip);
            })
            .on("hover", "li.task ul .reveal", function () {
                $(this).attr("title", lang.reveal_tip);
            });

    };

    // return only public methods
    return pub;

}());