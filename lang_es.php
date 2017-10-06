<?php
namespace tpp;
global $lang;

/**
 * ENGLISH language
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
 *             this will pop up when you hover the mouse over the filter, to explain its purpose
 * colour:
 *             identifies which CSS class to use (CSS class name suffix, see '.bk-...' in style.css)
 *             currently valid colours are: blue, brown, cyan, gray, green, red, violet, yellow  (all soft pastel shades)
 * visible:
 *             should this filter be added to Filter sidebar (true),
 *             or just be available from the search box, or used in other filters (false)
 */
$lang['filter_settings'] = array(
    'hoy'      => array('*next | >week /date', 'Acciones para hoy', 'yellow', true),
    'esperando'   => array('*wait', 'Esperando', 'cyan', true),
    'delegada' => array('*deleg', 'Delegado', 'violet', true),
    'hacer'      => array('*todo', 'Todas las tareas incompletas', 'blue', true),
    'hecho'      => array('*done', 'Solo tareas completadas', 'gray', true),
    'fechado'     => array('*todo =date /date', 'Tareas incompletas con fecha', 'green', true),
    'mes'     => array('*todo >month /date', 'Para el próximo mes', 'green', true),
    'tarde'      => array('*todo <today /date', 'Tareas incompletas con fecha de caducidad', 'red', true),
);

// search engine intervals and commands (English => Other Language)
$lang['interval_names'] = array(
    'day'       => 'dia',
    'week'      => 'semana',
    'month'     => 'mes',
    'year'      => 'año',
    'yesterday' => 'ayer',
    'today'     => 'hoy',
    'tomorrow'  => 'mañana',
    'future'    => 'futuro',
    'past'      => 'pasado',
    'date'      => 'fecha',
);

// names of the various sorting "columns" (English => Other Language)
$lang['sort_names'] = array(
    'task'  => 'tarea',
    'date'  => 'fecha',
    'topic' => 'tema',
    'state' => 'estado',
);

// different states (English => Other Language)
$lang['state_names'] = array(
    'done'  => 'hecho',
    'todo'  => 'hacer',
    'next'  => 'siguiente',
    'wait'  => 'esperando',
    'deleg' => 'delegado',
);

// 0=done, 1=todo, etc.. done should always be first!
// REMAINS IN ENGLISH !!
$lang['state_order'] = array('done', 'todo', 'next', 'wait', 'deleg');

// colours used for various actions (in order of use)
// currently: none, next, wait, maybe (done has no colour)
// REMAINS IN ENGLISH !!
$lang['state_colours'] = array('none', 'yellow', 'cyan', 'violet');


// main headers and titles
$lang['orphaned']       = '[No Topic]';
$lang['no_tags']        = 'Sin etiquetas';
$lang['task_header']    = 'Tareas';
$lang['tag_header']     = 'Etiquetas';
$lang['project_header'] = 'Temas';
$lang['filter_header']  = 'Filtros';
$lang['search_header']  = 'Buscar: ';
$lang['project_title']  = 'Tema';

// new tab sample content
$lang['new_tab_content'] = "Nuevo proyecto:\n- nueva tarea #tag\n    nota simple";


// main toolbar buttons
$lang['edit_all_tip']        = 'Editar todas las tareas en un archivo';
$lang['archive_done_tip']    = 'Archivar tareas completadas';
$lang['trash_done_tip']      = 'Eliminar tareas completadas';
$lang['remove_actions_tip']  = 'Eliminar resaltado en todas las tareas';
$lang['insert_location_tip'] = 'Insertar nuevas tareas en la parte superior o inferior';
$lang['note_state_tip']      = 'Mostrar u ocultar notas de varias líneas';


// task related tips and buttons
$lang['search_box_tip']     = "Buscar palabras, etiquetas, filtros, o fechas [Enter]\nO escriba una nueva tarea [Ctrl+Enter]\n[Enfoque aquí: Shift+Enter]";
$lang['search_help_tip']    = "Necesita ayuda para buscar? Click para ayuda\n(Ctrl+Click para nueva página)";
$lang['startpage_tip']      = 'Volver a la vista predeterminada';
$lang['save_changes_tip']   = 'Guardar cambios';
$lang['cancel_changes_tip'] = 'Cancelar los cambios y volver a la vista de tareas';
$lang['rename_tip']         = 'Renombrar esta pestaña';
$lang['remove_tip']         = 'Eliminar esta pestaña';
$lang['new_tab_tip']        = 'Añadir nueva pestaña';
$lang['change_tab_tip']     = "Cambiar a esta pestaña";
$lang['reset_tab_tip']      = 'Volver a la vista predeterminada';
$lang['archive_tab_tip']    = 'Todas las tareas archivadas';
$lang['trash_tab_tip']      = 'Todas las tareas eliminadas';
$lang['clear_box_tip']      = 'Borrar el cuadro de búsqueda';
$lang['tag_click_tip']      = 'Filtrar por esta etiqueta';
$lang['sortable_tip']       = 'Clasificable';


// sent with task-buttons
$lang['next_button_tip']    = 'Resaltar como * acción siguiente';
$lang['wait_button_tip']    = 'Resaltar como * acción en espera';
$lang['maybe_button_tip']   = 'Resaltar como * acción delegada';
$lang['none_button_tip']    = 'Eliminar resaltado de acciones';
$lang['archive_button_tip'] = 'Archivar esta tarea';
$lang['trash_button_tip']   = 'Eliminar esta tarea';


// general control labels
$lang['find_lbl']    = 'Encontrar';
$lang['replace_lbl'] = 'Reemplazar';
$lang['help_lbl']    = 'Ayuda';
$lang['about_lbl']   = 'Acerca';
$lang['faq_lbl']     = 'FAQ';
$lang['website_lbl'] = 'Website';
$lang['go_lbl']      = 'Ir';
$lang['save_lbl']    = "Guardar\n (Ctrl+Enter)";
$lang['cancel_lbl']  = "Cancelar\n (Esc)";
$lang['trash_lbl']   = 'Basura';
$lang['archive_lbl'] = 'Archivo';
$lang['placeholder'] = 'Añadir tarea [Ctrl+Enter] o buscar en la lista [Enter]';
$lang['language']    = 'Idioma';


// used before date intervals in result interface
$lang['next_lbl']    = 'en el próximo';
$lang['prev_lbl']    = 'en el anterior';
$lang['before_lbl']  = 'antes';
$lang['after_lbl']   = 'después';
$lang['no_date_hdr'] = 'sin fecha';


// miscellaneous
$lang['deleted_lbl'] = 'Eliminado:';


// login general form labels
$lang['username_lbl']       = 'nombre de usuario';
$lang['email_lbl']          = 'dirección de email';
$lang['password_lbl']       = 'contraseña';
$lang['repeatpassword_lbl'] = 'repita contraseña';
$lang['login_lbl']          = 'Iniciar sesión';
$lang['register_lbl']       = 'Registrar';
$lang['forgotpassword_lbl'] = 'Olvidó la contraseña';
$lang['logout_lbl']         = 'Cerrar sesión';
$lang['logged_in_as_lbl']   = 'Iniciar sesión:';


// login allowed pattern decription
$lang['username_pattern'] = 'Permitido: 0-9, a-z, A-Z; Longitud: 2-32 caracteres';
$lang['password_pattern'] = 'Permitido: 0-9, a-z, A-Z; Longitud: 2-32 caracteres';


// login msgs
$lang['login_msg']               = 'Inicie sesión o regístrese';
$lang['registration_msg']        = 'Se registró correctamente </br>Ahora puede iniciar sesión';
$lang['login_failed_msg']        = 'Inicio de sesión fallido</br>Corrija los errores y vuelva a intentarlo';
$lang['registration_failed_msg'] = 'Registro fallido</br>Corrija los errores y vuelva a intentarlo';


// login errors
$lang['no_such_user_err']       = 'No existe ese nombre de usuario.</br>Está resgistrado?';
$lang['user_exists_err']        = 'Nombre de usuario no disponible';
$lang['invalid_username_err']   = 'Nombre de usuario no válido</br>(' . $lang['username_pattern'] . ')';
$lang['invalid_password_err']   = 'Contraseña inválida/br>(' . $lang['password_pattern'] . ')';
$lang['nonmatch_passwords_err'] = 'Las contraseñas no coinciden';
$lang['invalid_email_err']      = 'Dirección de email inválida';
$lang['userfile_missing_err']   = 'Falta el archivo que contiene la lista de usuarios, se ha creado una nueva.';


// ****************
// ** JAVASCRIPT **
// ****************


// colours are taken from bk-* colours in style.less
$jslang['add_msg']        = array('Tarea añadida', 'blue');
$jslang['edit_msg']       = array('Tarea editada', 'yellow');
$jslang['trash_msg']      = array('Tarea eliminada', 'red');
$jslang['arch_msg']       = array('Tarea archivada', 'orange');
$jslang['trash_done_msg'] = array('Tareas completada eliminadas', 'red');
$jslang['arch_done_msg']  = array('Tareas completadas archivadas', 'orange');

$jslang['rename_msg']      = 'Nuevo nombre para la pestaña?';
$jslang['remove_msg']      = 'Eliminar esta pestaña?';
$jslang['create_msg']      = 'Nombre de la nueva pestaña?';
$jslang['search_msg']      = ''; // currently unused
$jslang['lang_change_msg'] = 'Idioma cambiado! Recargando...';

$jslang['editable_tip'] = 'Realice los cambios y haga clic en [Save] o [Cancel]';
$jslang['save_tip']     = $lang['save_lbl'];
$jslang['cancel_tip']   = $lang['cancel_lbl'];

$jslang['tag_click_tip']     = $lang['tag_click_tip'];
$jslang['edit_in_place_tip'] = 'Doble clic para editar la tarea';
$jslang['project_click_tip'] = 'Ver solo este tema';
$jslang['mark_complete_tip'] = 'Alternar la tarea como hecha / por hacer';
$jslang['reveal_tip']        = "Toggle the note";
$jslang['sort_tip']          = '&#10; -O- Arrastrar para cambiar orden del elemento';
