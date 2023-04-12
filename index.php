<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

// Inclui as classes
include 'Usuario.php';
include 'UsuarioDAO.php';

// Cria uma instância da classe UsuarioDAO
$usuarioDAO = new UsuarioDAO();

// Verifica se o formulário de inserção foi submetido
if(isset($_POST['inserir'])) {
  // Cria um novo objeto Usuario com os dados do formulário
  $usuario = new Usuario($_POST['nome'], $_POST['email']);

  // Insere o usuário no banco de dados
  $usuarioDAO->inserir($usuario);
}

// Verifica se o formulário de atualização foi submetido
if(isset($_POST['atualizar'])) {
  // Cria um novo objeto Usuario com os dados do formulário
  $usuario = new Usuario($_POST['nome'], $_POST['email']);
  $usuario->setId($_POST['id']);

  // Atualiza o usuário no banco de dados
  $usuarioDAO->atualizar($usuario);
}

// Verifica se o formulário de exclusão foi submetido
if(isset($_POST['excluir'])) {
  // Cria um novo objeto Usuario com o ID do formulário
  $usuario = new Usuario('', '');
  $usuario->setId($_POST['id']);

  // Exclui o usuário do banco de dados
  $usuarioDAO->excluir($usuario);
}

// Busca todos os usuários cadastrados no banco de dados
$usuarios = $usuarioDAO->listar();

?>

<!-- Formulário de inserção -->
<form method="POST">
  <label>Nome:</label>
  <input type="text" name="nome" required>
  <label>Email:</label>
  <input type="email" name="email" required>
  <button type="submit" name="inserir">Inserir</button>
</form>

<!-- Tabela de listagem -->
<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Nome</th>
      <th>Email</th>
      <th>Ações</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($usuarios as $usuario): ?>
      <tr>
        <td><?php echo $usuario->getId(); ?></td>
        <td><?php echo $usuario->getNome(); ?></td>
        <td><?php echo $usuario->getEmail(); ?></td>
        <td>
          <!-- Formulário de atualização -->
          <form method="POST">
            <input type="hidden" name="id" value="<?php echo $usuario->getId(); ?>">
            <input type="hidden" name="nome" value="<?php echo $usuario->getNome(); ?>">
            <input type="hidden" name="email" value="<?php echo $usuario->getEmail(); ?>">
            <button type="submit" name="atualizar">Atualizar</button>
          </form>
          <!-- Formulário de exclusão -->
          <form method="POST">
            <input type="hidden" name="id" value="<?php echo $usuario->getId(); ?>">
            <button type="submit" name="excluir">Excluir</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php

// Fecha a conexão com o banco de dados
$usuarioDAO->fecharConexao();

?>
