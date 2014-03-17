<?php

/**
 * Classe 
 */

abstract class DefaultController {

    /**
     *
     * @var Helpers
     */
    protected $helper;

    public function __construct($helper = null) {
        $this->helper = $helper;
        $this->init();
    }

    public function init() {
        
    }

    public function action($action) {
        if (method_exists($this, $action)) {
            $this->$action();
        } else {
            exit(var_dump("Essa action $action nao existe"));
        }
    }

}

?>