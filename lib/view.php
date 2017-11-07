<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Lib;

class View {
    protected $data; // Todos os dados que vão do back-end para o front-end
    protected $path; // Caminho para aparecer na tela
    
    protected static function getDefaultViewPath() {
        $router = App::getRouter();
        
        if(!$router){
            return false;
        }
        
        $controller_dir = $router->getController();
        $template_name = $router->getMethodPrefix().$router->getAction().'.php';
        
        return VIEW_PATH . DS . $controller_dir . DS . $template_name;
    }
    
    public function __construct($data = array(), $path = null) {
        if(!$path){
            $path = self::getDefaultViewPath();
        }
        
        if(!file_exists($path)){
            throw new \Exception("Template não foi encontrado: {$path}");
        }
        $this->data = $data;
        $this->path = $path;
    }
    
    public function render() {
        // Gera o código da tela
        $data = $this->data;
        
        ob_start();
        include $this->path;
        $content = ob_get_clean();
        
        return $content;
    }

}
