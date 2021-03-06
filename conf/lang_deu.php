<?php
namespace tpp;
global $lang;

/**
 * Deutsch / GERMAN language
 */


/**
 * These filters can be changes to suit your needs/whims!
 *
 * Each filter consists of: name => array(expression, tooltip, colour, visibility),
 * 
 * name:       
 *             this will be displayed to the user (no spaces allowed, however _ will be replced by space for display)
 * expression: 
 *             any valid search as used in search box (see help file), multiple terms are supported
 *             the expression can use either the language specific commands/intervals as below, or english (more consistent)
 *             you can even reuse other filter to create a new one, just put the = in front, e.g. '=late'
 * tooltip:    
 *             this will pop up when you hover the mouse over the filter, to explain it's purpose
 * colour:     
 *             identifies which CSS class to use (CSS class name suffix, see '.bk-...' in style.css)
 *             currently valid colours are: blue, brown, cyan, gray, green, red, violet, yellow  (all soft pastel shades)
 * visible:    
 *             should this filter be added to Filter sidebar (true),
 *             or just be available from the search box, or used in other filters (false)
 */
$lang['filter_settings']    = array(
                                    'unblockiert'   => array('*next | >week \\date', 'Unblockierte Aufgaben inklusive nächster Woche', 'yellow', true),
                                    'bald_fällig'   => array('*todo >month \\date', 'Fällig im nächsten Monat', 'green', true),
                                    'blockiert'     => array('*wait', 'Aufgaben wartend auf jemanden/etwas', 'cyan', true),
                                    'eventuell'     => array('*maybe', 'Mögliche Aufgaben für die Zukunft', 'violet', true),
                                    'pendent'       => array('*todo', 'Alle pendenten Aufgaben', 'blue', true),
                                    'erledigt'      => array('*done', 'Nur erledigte Aufgaben', 'gray', true),
                                    'mit_Datum'     => array('*todo =date \\gdate', 'Pendente Aufgaben mit Datum', 'green', true),
                                    'überfällig'    => array('*todo <today \\gdate', 'Überfällige pendente Aufgaben', 'red', true),
                                    );

// search engine intervals and commands (English => Other Language)
$lang['interval_names']     = array(
                                    'date'      => 'Datum',
                                    'future'    => 'zukünftig',
                                    'past'      => 'vergangene',
                                    'yesterday' => 'gestern',
                                    'today'     => 'heute',
                                    'tomorrow'  =>'morgen',
                                    'day'       => 'Tag',
                                    'week'      => 'Woche',
                                    'month'     => 'Monat',
                                    'year'      => 'Jahr',
                                    );

// names of the various sorting "columns" (English => Other Language)
$lang['sort_names']         = array(
                                    'task'  => 'Aufgabe',
                                    'date'  => 'Datum',
                                    'topic' => 'Projekt',
                                    'state' => 'Status',
                                    );

// different states (sequence should not be changed) (English => Other Language)
$lang['state_names']        = array(
                                    'todo'  => 'zutun',
                                    'next'  => 'unblockierte',
                                    'wait'  => 'wartend',
                                    'maybe' => 'eventuell',
                                    'done'  => 'erledigt',
                                    );

// 0=todo, 1=next, etc.. done should always be last!
// REMAINS IN ENGLISH !!
$lang['state_order']        = array('todo', 'next', 'wait', 'maybe', 'done');

// colours used for various states (in order of use)
// currently: none, next, wait, maybe (done has no colour)
// REMAINS IN ENGLISH !!
$lang['state_colours']      = array('none', 'yellow', 'cyan', 'violet', '');


// main headers and titles
$lang['orphaned']           = '[Kein Projekt]';
$lang['no_tags']            = 'Keine Tags';
$lang['task_header']        = 'Aufgaben';
$lang['tag_header']         = 'Tags';
$lang['project_header']     = 'Projekte';
$lang['filter_header']      = 'Filter';
$lang['search_header']      = 'Suche: ';


// new tab sample content
$lang['new_tab_content']    = "Neues Projektt:\n- neue Aufgabe #tag\n    eine einfache Notiz";


// main toolbar buttons
$lang['edit_all_tip']       = 'Als Klartext editieren';
$lang['archive_done_tip']   = 'Alle abgeschlossenen Aufgaben archivieren';
$lang['trash_done_tip']     = 'Alle abgeschlossenen Aufgaben löschen';
$lang['remove_actions_tip'] = 'Alle Highlights von den Aufgaben entfernen';


// task related tips and buttons
$lang['search_box_tip']     = "Gib Wörter, Tags, Kommandos oder Daten ein um danach zu suchen, oder gib eine neue Aufgabe ein; dann drück ENTER";
$lang['search_help_tip']    = "Brauchst Du Hilfe beim Suchen? Klick um die Kurzübersicht zu öffnen (Ctrl+click für eine neue Seite)";
$lang['startpage_tip']      = 'Zurück zur Standardansicht';
$lang['save_changes_tip']   = 'Speichere deine Änderungen';
$lang['cancel_changes_tip'] = 'Alle Änderungen verwerfen und zur Aufgabenansicht zurückkehren';
$lang['rename_tip']         = 'Diese Tab umbenennen';
$lang['remove_tip']         = 'Diese Tab löschen';
$lang['new_tab_tip']        = 'Ein neues Tab hinzufügen';
$lang['change_tab_tip']     = 'Zu diesem Tab wechseln. Ungespeicherte Änderungen bleiben erhalten';
$lang['reset_tab_tip']      = 'Diese Tab zur Standardansicht zurücksetzen';
$lang['archive_tab_tip']    = 'Archivierte Aufgaben anzeigen';
$lang['trash_tab_tip']      = 'Gelöschte Aufgaben anzeigen';
$lang['clear_box_tip']      = 'Die Suchbox zurücksetzen';
$lang['tag_click_tip']      = 'Klick um nach diesem Tag zu filtern';
$lang['sortable_tip']       = 'Sortierbar';


// sent with task-buttons
$lang['next_button_tip']    = 'Aktion wechseln: *pendent';
$lang['wait_button_tip']    = 'Aktion wechseln: *wartend';
$lang['maybe_button_tip']   = 'Aktion wechseln: *eventuell';
$lang['none_button_tip']    = 'Aktion wechseln: keine';
$lang['archive_button_tip'] = 'Diese Aufgabe archivieren';
$lang['trash_button_tip']   = 'Diese Aufgabe löschen';


// general control labels
$lang['find_lbl']           = 'Suchen:';
$lang['replace_lbl']        = 'Ersetzen:';
$lang['help_lbl']           = 'Hilfe';
$lang['about_lbl']          = 'Über';
$lang['faq_lbl']            = 'FAQ';
$lang['website_lbl']        = 'Webseite';
$lang['go_lbl']             = 'Go';
$lang['save_lbl']           = 'Speichern';
$lang['cancel_lbl']         = 'Abbrechen';
$lang['trash_lbl']          = 'Mülleimer';
$lang['archive_lbl']        = 'Archiv';
$lang['placeholder']        = 'Erstell eine Aufgabe -ODER- Gib eine Suchanfrage ein...';
$lang['language']           = 'Sprache';


// used before date intervals in result interface
$lang['next_lbl']           = 'in den nächsten';
$lang['prev_lbl']           = 'in den letzten';
$lang['before_lbl']         = 'vor';
$lang['after_lbl']          = 'nach';
$lang['no_date_hdr']        = 'Kein Datum';


// miscellaneous
$lang['deleted_lbl']        = 'Erlöscht:';


// login general form labels
$lang['username_lbl']         = 'Benutzername';
$lang['email_lbl']            = 'E-Mail-Adresse';
$lang['password_lbl']         = 'Passwort';
$lang['repeatpassword_lbl']   = 'Passwort wiederholen';
$lang['login_lbl']            = 'Einloggen';
$lang['register_lbl']         = 'Registrieren';
$lang['forgotpassword_lbl']   = 'Passwort vergessen';
$lang['logout_lbl']           = 'Ausloggen';
$lang['logged_in_as_lbl']     = 'Eingeloggt:';

// login allowed pattern decription
$lang['username_pattern']     = 'Erlaubt: 0-9, a-z, A-Z, Länge: 2-32 Zeichen';
$lang['password_pattern']     = 'Erlaubt: 0-9, a-z, A-Z, Länge: 2-32 Zeichen';


// login msgs
$lang['login_msg']               = 'Einloggen oder Registrieren herunten';
$lang['registration_msg']        = 'Registrierung erfolgreich</br>Jetzt hier anmelden';
$lang['login_failed_msg']        = 'Fehler beim Einloggen </br>Berichtigen und versuchen Sie es erneut';
$lang['registration_failed_msg'] = 'Fehler bei der Registrierung</br>Berichtigen und versuchen Sie es erneut';


// login errors
$lang['no_such_user_err']       = 'Keine solche Benutzernamen</br>Haben Sie schon registriert?';
$lang['user_exists_err']        = 'Benutzername bereits vergeben';
$lang['invalid_username_err']   = 'Benutzername ist ungültig</br>(' . $lang['username_pattern'] . ')';
$lang['invalid_password_err']   = 'Passwort ist ungültig</br>(' . $lang['password_pattern'] . ')';
$lang['nonmatch_passwords_err'] = 'Zweites Passwort stimmt nicht mit dem Ersten überein';
$lang['invalid_email_err']      = 'Ihre E-Mail-Adresse ist nicht gültig';
$lang['userfile_missing_err']   = 'Die Benutzerliste fehlte, es wurde neu erstellt';


// ****************
// ** JAVASCRIPT **
// ****************


// colours are based on bk-* class colours in style.less
$jslang['add_msg']            = array('Aufgabe hinzugefügt', 'blue');
$jslang['edit_msg']           = array('Aufgabe geändert', 'yellow');
$jslang['trash_msg']          = array('Aufgabe gelöscht', 'red');
$jslang['arch_msg']           = array('Aufgabe archiviert', 'orange');
$jslang['trash_done_msg']     = array('Alle abgeschlossenen Aufgaben gelöscht', 'orange');
$jslang['arch_done_msg']      = array('Alle abgeschlossenen Aufgaben archiviert', 'orange');

$jslang['rename_msg']         = 'Neuer Name für dieses Tab?';
$jslang['remove_msg']         = 'Dieses Tab löschen?';
$jslang['create_msg']         = 'Name für das neue Tab?';
$jslang['search_msg']         = '';   // currently unused
$jslang['lang_change_msg']    = 'Sprache wechsel! Seite neu laden...';

$jslang['editable_tip']       = 'Applizier gewünschte Änderungen und klick Speichern oder Abbrechen';
$jslang['save_tip']           = $lang['save_lbl'];
$jslang['cancel_tip']         = $lang['cancel_lbl'];

$jslang['tag_click_tip']      = $lang['tag_click_tip'];
$jslang['edit_in_place_tip']  = 'Doppelklicken um diese Aufgabe direkt zu editieren';
$jslang['project_click_tip']  = 'Nur diese Projekt anzeigen';
$jslang['mark_complete_tip']  = 'Die Aufgabe als pendent/abgeschlossen markieren';
$jslang['reveal_tip']         = "Die Notiz anzeigen oder verstecken";
$jslang['sort_tip']           = '&#10; -ODER- Klick und ziehe um die Reihenfolge der Einträge zu ändern';