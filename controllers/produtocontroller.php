<?php

namespace Controllers;

use Lib\Controller;
use Models\Produto;
use Lib\Session;
use Lib\Router;
use Lib\App;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ProdutoController extends Controller{
    public function index() {
        $this->data['produtos'] = Produto::getProdutos(true);
    }   
    
    public function ver($idProduto) {
        $idProduto = filter_var($idProduto, FILTER_SANITIZE_NUMBER_INT);
        
        if($idProduto != FALSE){
            $this->data['produto'] = Produto::getProdutoPorId($idProduto);
        } 
    }
    
    public function admin_index () {
        $this->data['produtos'] = Produto::getProdutos();
    }
    
    public function admin_nova () {
        if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
            $disponivel = filter_input(INPUT_POST, 'disponivel')? 1 : 0;
            $valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            
            if($nome == FALSE || $descricao == FALSE) {
                Session::setFlash('Todos os campos são obrigatórios.');
                Router::redirect(App::getRouter()->getUrl('produto', 'nova'));
            }
            
            $produto = new Produto(0, $nome, $descricao, $disponivel, $valor);
            Produto::inserir($produto);
            
            Session::flash('Produto adicionado com sucesso.');
            Router::redirect(App::getRouter()->getUrl('produto'));
        }
    }
    
    public function admin_editar ($id) {
        $request = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        
        if($request === 'POST') {
            $idProduto = filter_input(INPUT_POST, 'idProduto', FILTER_SANITIZE_NUMBER_INT);
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
            $disponivel = filter_input(INPUT_POST, 'disponivel')? 1 : 0;
            $valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

            if($idProduto == FALSE || $idProduto <= 0) {
                Session::setFlash('Página não encontrada.');
                Router::redirect(App::getRouter()->getUrl('produto'));
            } else if($nome == FALSE || $descricao == FALSE | $valor == FALSE) {
                Session::setFlash('Todos os campos são obrigatórios.');
                Router::redirect(App::getRouter()->getUrl('produto', 'editar', [$idProduto]));
            }
            
            $usuario = Session::get('usuario');
            $produto = new Produto($idProduto, $nome, $descricao, $disponivel, $valor);
            Produto::atualizar($produto);
            
            Session::flash('Página atualizada com sucesso.');
            Router::redirect(App::getRouter()->getUrl('produto'));
        } else if($request === 'GET'){
            $idProduto = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
            
            if($idProduto == FALSE || $idProduto < 0) {
                Session::setFlash('Página não encontrada.');
                Router::redirect(App::getRouter()->getUrl('produto'));
            }
            
            $this->data['produto'] = Produto::getProdutoPorId($idProduto);
        }
    }
    
    public function admin_excluir ($id) {
        $idProduto = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
            
        if($idProduto == FALSE || $idProduto < 0) {
            Session::setFlash('Página não encontrada.');
            Router::redirect(App::getRouter()->getUrl('produto'));
        }

        Produto::excluir($idProduto);
        Session::setFlash('Página excluída com sucesso.');
        Router::redirect(App::getRouter()->getUrl('produto'));
    }
}
