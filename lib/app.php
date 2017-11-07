<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Lib;

use Lib\Router;
use Lib\View;
use Lib\Lang;
use Lib\DB;

class App {
    
    /*
     * @var Router
     */
    protected static $router;

    /*
     * @return Router
     */
    static function getRouter() {
        return self::$router;
    }
    
    static function getDb() {
        return self::$db;
    }

    // É chamada logo que a página é carregada (faz todo o trabalho do site)
    public static function run() {
        self::$router = new Router();
                
        Lang::load(self::$router->getLanguage());
        
        // Define diretório da classe controller
        $controller_class = 'Controllers\\'.ucfirst(self::$router->getController()).'Controller';
        $controller_method = strtolower(self::$router->getMethodPrefix().self::$router->getAction());
        
        $layout = self::$router->getRoute();

        if($layout == 'admin' && (Session::get('funcionario') == NULL || Session::get('funcionario')->getCargo() != 'admin')){
            if($controller_method != 'admin_login'){
                Router::redirect(self::$router->getUrl('funcionario', 'login', [], 'admin'));
            }
        }
        
        // Chama o controller
        $controller = new $controller_class();
        
        if(method_exists($controller, $controller_method)){
            $view_path = $controller->$controller_method(...self::$router->getParams());
            $view_object = new View($controller->getData(), $view_path);
            $content = $view_object->render();
        } else {
            // Se não existir, a pessoa está entrando em uma URL que não existe
            throw new \Exception("Método {$controller_method} da classe {$controller_class} não existe.");
        }
        
        $layout_path = VIEW_PATH . DS . $layout . '.php';
        $layout_view_object = new View(compact('content'), $layout_path);
        echo $layout_view_object->render();    
    }
}
