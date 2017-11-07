<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controllers;

use Lib\Controller;
use Models\Pedido;
use Lib\Session;
use Lib\Router;
use lib\App;

class PedidoController extends Controller {
    public function index() {
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
            $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_SANITIZE_NUMBER_INT);
            $produto = filter_input(INPUT_POST, 'Produto_idProduto', FILTER_SANITIZE_NUMBER_INT);
            $produto_existe = Pedido::existe($produto);
            
            if ($produto_existe == NULL){
                Session::setFlash('Nenhum produto possuí esse ID.');
                Router::redirect(App::getRouter()->getUrl('pedido'));
            }
            if ($nome == FALSE || $quantidade == FALSE || $endereco == FALSE || $produto == FALSE) {
                Session::setFlash('Todos os campos são obrigatórios.');
                Router::redirect(App::getRouter()->getUrl('pedido'));
            } else {
                $msg = new Pedido(0, $nome, $endereco, $quantidade, $produto);
                Pedido::insere($msg);
                
                Session::setFlash('Pedido enviado com sucesso.');
            } 
        }
    }
    
    public function admin_index() {
        $this->data['pedidos'] = Pedido::getPedidos();
    }
}