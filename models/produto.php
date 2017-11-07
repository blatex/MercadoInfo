<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Models;

use Lib\DB;

class Produto {

	private $idProduto;
	private $nome;
	private $descricao;
	private $valor;
	private $disponivel;

	public static function getProdutos($apenasDisponivel = FALSE){
        $conn = DB::getConnection();
        
        if ($apenasDisponivel == FALSE) {
            $query = 'SELECT `idProduto`, `nome`, `descricao`, `disponivel`, `valor` FROM `Produto`';
        } else {
            $query = 'SELECT `idProduto`, `nome`, `descricao`, `disponivel`, `valor` FROM `Produto` WHERE `disponivel` = 1';
        }
        
        $result = $conn->query($query);
        
        if ($result == FALSE) {
            throw new \Exception("Falha ao carregar lista de produtos. Erro: {$conn->error}");            
        }
        
        $produtos = [];
        while ($row = $result->fetch_assoc()) {
            $produtos[] = new Produto($row['idProduto'], $row['nome'], $row['descricao'], $row['disponivel'], $row['valor']);
        }
        
        $result->close();
        return $produtos;
    }

    public static function getProdutoPorId($idProduto){
        $conn = DB::getConnection();
        
        $query = 'SELECT `idProduto`, `nome`, `descricao`, `disponivel`, `valor` FROM `Produto` WHERE `idProduto` = ?';
        $stmt = $conn->prepare($query);
        if ($stmt == FALSE) {
            throw new \Exception("Falha ao carregar lista de páginas. Erro: {$conn->error}");
        }
        
        if ($stmt->bind_param('i', $idProduto) == FALSE) {
            throw new \Exception("Falha ao associar parâmetros. Erro: {$stmt->error}");
        }
        
        if ($stmt->execute() == FALSE) {
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error}");
        }
        
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $pagina = new Produto($row['idProduto'], $row['nome'], $row['descricao'], $row['disponivel'], $row['valor']);
        } else {
            $pagina = NULL;
        }
        
        $result->close();
        $stmt->close();
        return $pagina;
    }
    
    /*
     * @param Pagina $pagina
     * @return type
     * @throws \Exception
     */
    
    public static function inserir($produto) {
        $conn = DB::getConnection();
        
        $query = 'INSERT INTO `Produto` (`nome`, `descricao`, `disponivel`, `valor`) VALUES (?, ?, ?, ?)';
        $stmt = $conn->prepare($query);
        
        if ($stmt == FALSE) {
            throw new \Exception("Falha ao preparar query 1. Erro: {$conn->error}");
        }
        
        $nome = $produto->getNome();
        $descricao = $produto->getDescricao();
        $disponivel = $produto->getDisponivel();
        $valor = $produto->getValor();
        
        if ($stmt->bind_param('ssid', $nome, $descricao, $disponivel, $valor) == FALSE) {
            throw new \Exception("Falha ao associar parâmetros. Erro: {$stmt->error}");
        }
        
        if ($stmt->execute() == FALSE) {
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error}");
        }
        
        $stmt->close();
    }
    
    public static function atualizar($produto) {
        $conn = DB::getConnection();
        
        $query = 'UPDATE `Produto` SET `nome` = ?, `descricao` = ?, `disponivel` = ?, `valor` = ? WHERE `idProduto` = ?';
        $stmt = $conn->prepare($query);
        
        if ($stmt == FALSE) {
            throw new \Exception("Falha ao preparar query. Erro: {$conn->error}");
        }
        
        $idProduto = $produto->getIdProduto();
        $nome = $produto->getNome();
        $descricao = $produto->getDescricao();
        $disponivel = $produto->getDisponivel();
        $valor = $produto->getValor();
        
        if ($stmt->bind_param('ssidi', $nome, $descricao, $disponivel, $valor, $idProduto) == FALSE) {
            throw new \Exception("Falha ao associar parâmetros. Erro: {$stmt->error}");
        }
        
        if ($stmt->execute() == FALSE) {
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error}");
        }
        
        $stmt->close();
    }
    
    public static function excluir($idProduto) {
        $conn = DB::getConnection();
        
        $query = 'DELETE FROM `Produto` WHERE `idProduto` = ?';
        $stmt = $conn->prepare($query);
        
        if ($stmt == FALSE) {
            throw new \Exception("Falha ao preparar query. Erro: {$conn->error}");
        }
        
        if ($stmt->bind_param('i', $idProduto) == FALSE) {
            throw new \Exception("Falha ao associar parâmetros. Erro: {$stmt->error}");
        }
        
        if ($stmt->execute() == FALSE) {
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error}");
        }
        
        $stmt->close();
    }

	function getIdProduto() {
        return $this->idProduto;
    }

    function getNome() {
        return $this->nome;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getValor() {
        return $this->valor;
    }

    function getDisponivel() {
        return $this->disponivel;
    }

    function setIdProduto($idProduto) {
        $this->idProduto = $idProduto;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setDisponivel($disponivel) {
        $this->disponivel = $disponivel;
    }

	function __construct($idProduto, $nome, $descricao, $disponivel, $valor) {
        $this->idProduto = $idProduto;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->valor = $valor;
        $this->disponivel = $disponivel;
    }	
}