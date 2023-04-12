<?php
class UsuarioDAO {
    private $conn;
  
    public function __construct() {
      // realizar a conexão com o banco de dados
      $this->conn = new PDO('mysql:host=localhost;dbname=databasetest', 'root', '');
    }
  
    public function listar() {
      $stmt = $this->conn->prepare('SELECT * FROM usuarios');
      $stmt->execute();
  
      $usuarios = array();
  
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $usuario = new Usuario();
        $usuario->setId($row['id']);
        $usuario->setNome($row['nome']);
        $usuario->setEmail($row['email']);
  
        $usuarios[] = $usuario;
      }
  
      return $usuarios;
    }
  
    public function inserir($usuario) {
      $stmt = $this->conn->prepare('INSERT INTO usuarios (nome, email) VALUES (?, ?)');
      $stmt->bindValue(1, $usuario->getNome());
      $stmt->bindValue(2, $usuario->getEmail());
      $stmt->execute();
  
      $usuario->setId($this->conn->lastInsertId());
    }
  
    public function atualizar($usuario) {
      $stmt = $this->conn->prepare('UPDATE usuarios SET nome = ?, email = ? WHERE id = ?');
      $stmt->bindValue(1, $usuario->getNome());
      $stmt->bindValue(2, $usuario->getEmail());
      $stmt->bindValue(3, $usuario->getId());
      $stmt->execute();
    }
  
    public function excluir($id) {
      $stmt = $this->conn->prepare('DELETE FROM usuarios WHERE id = ?');
      $stmt->bindValue(1, $id);
      $stmt->execute();
    }
  }
  