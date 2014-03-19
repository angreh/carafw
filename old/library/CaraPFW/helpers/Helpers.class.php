<?php

class Helpers {

    private static $_instance = null;

    public static function getInstance() {
        if (self::$_instance == null)
            self::$_instance = new self();
        return self::$_instance;
    }

    public function Request() {
        return $this->_getHelperInstance('Request');
    }

    public function AutoLoader() {
        return $this->_getHelperInstance('Autoloader'); /* decrepeted */
    }

    private function _getHelperInstance($helperName) {

        require_once LIBRARY_PATH . "CaraPFW/helpers/$helperName.class.php";
        return $helperName::getInstance();
    }

}
