<?php
namespace App\Core ;

use App\Controllers\MainController;



/**
 * Main Router
 */
class Main 
{
    public function start() 
    {
        session_start() ;
        
        $uri = $_SERVER['REQUEST_URI'] ;

        if (!empty($uri) && $uri != '/' && $uri[-1] === '/') {
            // deletion of trailing slash
            $uri = substr($uri, 0, -1) ;
            http_response_code(301) ;
            
            header ('Location: ' . $uri) ;
        }

        // Management of parameters : p=controller/method/parameters
        $parameters = explode('/', $_GET['p']) ;
        
        if ($parameters[0] != '') {
            // 1st parameter
            $controller = '\\App\\Controllers\\' . ucfirst(array_shift($parameters)) . 'Controller' ;
            $controller = new $controller() ;

            // 2nd parameter
            $action = isset($parameters[0]) ? array_shift($parameters) : 'index' ;

            if (method_exists($controller, $action)) {
                // isset($parameters[0]) ? $controller->$action($parameters) : $controller->$action() ;
                isset($parameters[0]) ? call_user_func_array([$controller, $action], $parameters) : $controller->$action() ;
            }
            else {
                http_response_code(404) ;
                echo 'La page recherchée n\'existe pas' ;
            }
        }
        else {
            // If no parameter is present, instantiation of the default controller
            $controller = new MainController ;
            $controller->index() ;
        }
    }
}