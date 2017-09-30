<?php

require_once 'ConexaoDAO.php';

class UsuarioDAO {
    
    private $conexao;

    public function __construct() {
        $this->conexao = ConexaoDAO::getConexao();
    }
    
    function inserir(Usuario $usuario) {
        $sql = "insert into usuario (nome, email, senha) values ('{$usuario->getNome()}', '{$usuario->getEmail()}', '{$usuario->getSenha()}') returning id;";
        $resultado = pg_query($this->conexao, $sql);
        $linha = pg_fetch_array($resultado);
        $usuario->setId($linha['id']);
    }
    
    function alterar(Usuario $usuario) {
        $sql = "update usuario set nome='{$usuario->getNome()}', email='{$usuario->getEmail()}', senha='{$usuario->getSenha()}'"
        . "where id={$usuario->getId()}";
        pg_query($this->conexao, $sql);
    }
    
    function excluir($id) {
        $sql = "delete from usuario where id = " . $id;
        pg_query($this->conexao, $sql);
    }
    
    function listar() {
        $usuarios = array();
        $sql = "select * from usuario";
        $resultado = pg_query($this->conexao, $sql);
        while($usuario =  pg_fetch_array($resultado)) {
            array_push($usuarios, $usuario);
        }
        return $usuarios;
    }
    
    function buscar($id) {
        $sql = "select * from usuario where id = " . $id;
        $resultado = pg_query($this->conexao, $sql);
        return pg_fetch_array($resultado);
    }
}
