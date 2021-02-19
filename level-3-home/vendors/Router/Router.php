<?php

class Router {

    public function __construct() {
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function run() {
        $requestURI = $this->getURI();
        $requestURI = $this->slicePROOT($requestURI);

        $urlParts = explode("/",$requestURI);

        // Set 'controller' name from URL. First param from array
        $controller = ( isset($urlParts[0]) && $urlParts[0] != "" ) ? ucwords($urlParts[0]) . "Controller" : DEFAULT_CONTROLLER . "Controller"; 
        array_shift($urlParts );

        // Set 'action' name from URL. First param from array
        $action = ( isset($urlParts[0]) && $urlParts[0] != "" ) ? $urlParts[0] . "Action" : DEFAULT_ACTION; 
        array_shift($urlParts );

        // Set 'params', in URL array params left.
        $queryParams = $urlParts;

        // We declare a new class. The controller and the name of the action are transmitted to the controller object
        try {
            $dispatch = new $controller( $controller, $action );
        } catch (Error $e) {
            var_dump("404");die;
        }

        if ( method_exists($controller, $action) ) {
            call_user_func_array([$dispatch, $action], $queryParams );
        } else {
            die("That method does not exist in the controller \"{$controller}\"");
        }
    }

    /**
     * Return request URI
     *
     * @return string
     */
    private function getURI() {
        return $_SERVER["REQUEST_URI"];
    }

    /**
     * Relace in request URI PROOT
     *
     * @param string $url
     * @return string
     */
    private function slicePROOT( $url ) {
        return str_replace( PROOT, "", $url );
    }

}