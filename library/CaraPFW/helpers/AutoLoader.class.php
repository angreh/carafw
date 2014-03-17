<?php

/*
 * Classe responsável por carregar as classe do sistema
 */

class AutoLoader {

    /*
     * Própria instância estática
     */
    private static $_instance = null;

    /**
     * Pega a instancia ativa da classe ou cria uma caso nao exista e a retorna
     *
     * @return AutoLoader
     */
    public static function getInstance() {
        if (self::$_instance == null)
            self::$_instance = new self();
        return self::$_instance;
    }

    /*
     * Registra o autoloader como buscador de classes para o php
     */
    public function register() {
        spl_autoload_register(array($this, '_autoloader'));
    }

    /*
     * Essa função mapeia do nome da classe e deifne onde o php vai buscar
     */
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
