<?php

/**
 * Description of Helpers
 *
 * @author Angreh
 */
class Helpers {

    private static $_instance = null;

    /**
     *
     * @return Helpers
     */
    public static function getInstance() {
        if (self::$_instance == null)
            self::$_instance = new self();
        return self::$_instance;
    }


    /**
     *
     * @return Request
     */
    public function Request() {
        return $this->_getHelperInstance(__FUNCTION__);
    }

    /**
     *
     * @return AutoLoader
     */
    public function AutoLoader() {
        return $this->_getHelperInstance(__FUNCTION__);
    }

    

    private function _getHelperInstance($helperName) {

        require_once LIBRARY_PATH . "CaraPFW/helpers/$helperName.class.php";
        return $helperName::getInstance();
    }

}

//    public function __call($name, $arguments) {
//        return $this->_getHelperInstance($name);
//    }
