<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Models;

use Lib\DB;

class Pedido {

	private $idPedido;
	private $nome;
	private $endereco;
	private $quantidade;
	private $Produto_idProduto;

    public static function getPedidos(){
        $conn = DB::getConnection();
        
        $query = 'SELECT `idPedido`, `nome`, `endereco`, `quantidade`, `Produto_idProduto` FROM `Pedido`';
        $result = $conn->query($query);
        
        if ($result == FALSE) {
            throw new \Exception("Falha ao carregar lista de pedidos. Erro: {$conn->error}");            
        }
        
        $pedidos = [];
        while ($row = $result->fetch_assoc()) {
            $pedidos[] = new Pedido($row['idPedido'], $row['nome'], $row['endereco'], $row['quantidade'], $row['Produto_idProduto']);
        }
        
        $result->close();
        return $pedidos;
    }

    public static function existe($id){
        $conn = DB::getConnection();

        $query = 'SELECT `idProduto` FROM `Produto` WHERE `idProduto` = ?';
        $stmt = $conn->prepare($query);

        if ($stmt == FALSE) {
            throw new \Exception("Falha ao preparar query. Erro: {$conn->error}");
        }

        if ($stmt->bind_param('s', $id) == FALSE) {
            throw new \Exception("Falha ao associar parâmetros. Erro: {$stmt->error}");
        }  

        if ($stmt->execute() == FALSE) {
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error}");
        }
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_array();
    }
    
    public static function insere($msg) {
        $conn = DB::getConnection();
        
        $query = 'INSERT INTO `Pedido` (`nome`, `endereco`, `quantidade`, `Produto_idProduto`) VALUES (?, ?, ?, ?)';
        $stmt = $conn->prepare($query);
        
        if ($stmt == FALSE) {
            throw new \Exception("Falha ao preparar query. Erro: {$conn->error}");
        }
        
        $nome = $msg->getNome();
        $endereco = $msg->getEndereco();
        $quantidade = $msg->getQuantidade();
        $produto = $msg->getProduto_idProduto();
        
        if ($stmt->bind_param('ssss', $nome, $endereco, $quantidade, $produto) == FALSE) {
            throw new \Exception("Falha ao associar parâmetros. Erro: {$stmt->error}");
        }        
        if ($stmt->execute() == FALSE) {
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error}");
        }
        
        $stmt->close();
    }

	function getIdPedido() {
        return $this->idPedido;
    }

    function getNome() {
        return $this->nome;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getQuantidade() {
        return $this->quantidade;
    }

    function getProduto_idProduto() {
        return $this->Produto_idProduto;
    }

    function setIdPedido($idPedido) {
        $this->idPedido = $idPedido;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }

    function setProduto_idProduto($Produto_idProduto) {
        $this->Produto_idProduto = $Produto_idProduto;
    }

	function __construct($idPedido, $nome, $endereco, $quantidade, $Produto_idProduto) {
        $this->idPedido = $idPedido;
        $this->nome = $nome;
        $this->endereco = $endereco;
        $this->quantidade = $quantidade;
        $this->Produto_idProduto = $Produto_idProduto;
    }	
}