<?php

/*
 * Essa é classe responsável por separarar o que vem do endereço do site e 
 * dizer queal das partes é modulo, controller, action e variáveis retornando seu 
 * nome devidamente formatado
 * 
 * Responsavél também por retornar os nome e rocalizações dos arquivos dos modulos,
 * controllers e etc ...
 */

class Request {

    /**
     * guarda a instancia estatica dessa classe
     */
    private static $_instance = null;

    /**
     * guarda a requisição original do servidor
     * 
     * @var string 
     */
    private $resquest;

    /**
     * 
     * @var string módulo
     */
    private $module;

    /**
     * 
     * @var string controler
     */
    private $controller;

    /**
     * 
     * @var string action
     */
    private $action;

    /**
     * guarda as variaveis da requisição
     * 
     * @var array 
     */
    private $vars;

    /**
     * guarda o nome da classe do controller
     * 
     * @var string 
     */
    private $controllerClassName;

    /**
     * Pega a instancia ativa da classe ou cria uma caso nao exista e a retorna
     *
     * @return Request
     */
    public static function getInstance() {
        if (self::$_instance == null)
            self::$_instance = new self();
        return self::$_instance;
    }

    /**
     * Define todas as variavéis de modulos, controlers, ações e variáveis
     */
    public function init($options = array()) {

        $default = array(
            'defaultModule' => 'site',
            'defaultController' => 'home',
            'defaultAction' => 'index'
        );

        $options = (object) array_merge($default, $options);

        //Remove a primeira '/' do request
        $request = substr($_SERVER['REQUEST_URI'], 1);
        $this->resquest = (string) $request;

        //trasnforma em array
        $request = explode('/', $request);

        //Define modulo
        if (isset($request[0]) && $request[0] != '') {
            $this->module = $request[0];
        } else {
            $this->module = strtolower($options->defaultModule);
        }

        //define controller
        if (isset($request[1])) {
            $this->controller = $request[1];
        } else {
            $this->controller = strtolower($options->defaultController);
        }

        //define o nome da classe do controller
        $this->controllerClassName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->controller))) . '_' . ucfirst($this->module) . '_Controller';

        //define action
        if (isset($request[2])) {
            $this->action = $request[2];
        } else {
            $this->action = strtolower($options->defaultAction);
        }

        //define variáveis
        $requestParamsCount = count($request);
        if ($requestParamsCount > 4) {
            $vars = array_slice($request, 3);
            foreach ($vars as $key => $value) {
                //se for par salva a chave e se for impar atribui o valor a chave previamente definida 
                if (!( $key & 1 )) {
                    $auxKey = $value;
                } else {
                    $this->vars[$auxKey] = $value;
                }
            }
        }
    }

    /**
     * 
     * @return string endereço do arquivo do controller
     */
    public function getControllerPath() {
        return SYSTEM_PATH . 'modules/' . $this->module . '/controllers/' . $this->controllerClassName . '.class.php';
    }
    
    /**
     * 
     * @return string nome da classe do controller
     */
    public function getControllerClassName(){
        return $this->controllerClassName;
    }
    
    /**
     * 
     * @return string action
     */
    public function getAction(){
        return $this->action;
    }
    

}
