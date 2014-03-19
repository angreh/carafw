<?php

class AutoLoader {

    private static $_instance = null;

    public static function getInstance() {
        if (self::$_instance == null)
            self::$_instance = new self();
        return self::$_instance;
    }

    public function register() {
        spl_autoload_register(array($this, '_autoloader'));
    }


    private function _autoloader($name) {


        $pieces = explode('_', $name);

        if (isset($pieces[2])) {
            $type = $pieces[2];
            $module = $pieces[1];
        } else {
            $type = '';
        }

        $classTypes = array('Mapper', 'Model', 'Controller');

        if (in_array($type, $classTypes)) {
            require SYSTEM_PATH . 'modules/' . strtolower($module) . '/' . strtolower($type) . 's/' . $name . '.class.php';
        } else {
            $name = str_replace('_', '/', $name);
            require LIBRARY_PATH . 'CaraPFW/helpers/' . $name . '.class.php';
        }
    }

}

?>