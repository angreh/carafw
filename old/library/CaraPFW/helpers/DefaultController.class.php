<?php

/**
 * Classe 
 */

abstract class DefaultController {

    protected $helper;

    public function __construct($helper = NULL) {
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
    
    public function indexAction(){
        
    }

}

?>