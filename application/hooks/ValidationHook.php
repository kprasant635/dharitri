<?php
class ValidationHook {

    public function run() {
        
        $CI =& get_instance();
        $controller = $CI->router->fetch_class();
        if (in_array($controller, ['LegacyDataUpdation', 'chitha_basic_deo','JamaEditEntry','JunkDagDelete'])) {
            $CI->load->library('ValidationLib');
            $CI->validationlib->checkAccess();
        }
    }
}
