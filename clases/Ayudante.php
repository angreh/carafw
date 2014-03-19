<?php

/**
 * Gestionar la instancia de clases que se utilizarán en el proyecto
 * 
 * @author Sisardo (piolajones@gmail.com)
 * @version 1.0
 */
class Ayudante {

    /**
     * Instancia de la clase
     * @var Usuarios 
     */
    private $usuarios;
    
    /**
     * Instancia de la clase
     * @var Template
     */
    private $template;

    /**
     * Crea la instancia de la clase Template o utiliza el vigente
     * 
     * @param string $filename contiene el nombre del archivo que se cargará
     * 
     * @return Template
     */
    public function Template($filename) {
        if ($this->template == NULL) {
            require $_SERVER["DOCUMENT_ROOT"] . '/clases/Template.class.php';
            $this->template = new Template($filename);
        }
        return $this->template;
    }

    /**
     * Crea la instancia de la clase Usuarios o utiliza el vigente
     * 
     * @return Usuarios
     */
    public function Usuarios() {
        if ($this->usuarios == NULL) {
            require $_SERVER["DOCUMENT_ROOT"] . '/clases/Usuarios.php';
            $this->usuarios = new Usuarios();
        }
        return $this->usuarios;
    }

}
