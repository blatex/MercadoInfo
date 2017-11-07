<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controllers;

use Lib\App;
use Lib\Controller;
use Lib\Session;
use Lib\Router;
use Models\Funcionario;

class FuncionarioController extends Controller {
    public function admin_login(){
        if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST'){
            $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
            $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
            
            if($login == FALSE || $senha == FALSE){
                Session::setFlash('Todos os campos são obrigatórios.');
                Router::redirect(App::getRouter()->getUrl('funcionario', 'login', [], 'admin'));
            }
            
            $funcionario = Funcionario::getByLogin($login);

            if($funcionario == NULL || password_verify($senha, $funcionario->getSenha()) == FALSE){
                Session::setFlash('Não foi possível encontrar um usuário com os dados informados.');
            } else {
                Session::set('funcionario', $funcionario);
            }
            
            Router::redirect(App::getRouter()->getUrl('', '', [], 'admin'));
        }
    }
    
    public function admin_logout() {
        Session::destroy();
        Router::redirect(App::getRouter()->getUrl('', '', [], 'admin'));
    }
}