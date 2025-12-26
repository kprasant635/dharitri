<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

// the following part will execute every time immediately after your controller is instantiated
/*$hook ['post_controller_constructor'] = array(
    'function' => array('checkLogin'),
    'filename' => 'profiler_hook.php',
    'filepath' => 'hooks',
);*/

$hook['post_controller'] = array(
        'class'    => 'hooks',
        'function' => 'checkLogin',
        'filename' => 'hooks.php',
        'filepath' => 'hooks',
       
);


/* End of file hooks.php */
/* Location: ./application/config/hooks.php */