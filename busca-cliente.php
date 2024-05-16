<?php
session_start();
require_once './banco.php';
require_once './class.php';

$db = new banco;

if(isset($_POST['buscar'])) {
  $filtroUsuario = new FiltroUsuario();
  $result = $filtroUsuario->filtrarUsuarios($_POST['buscar']);
} else {
  $usuario = new Usuario();
  $result = $usuario->listar_usuarios();
}

if(isset($_POST['editar_usuario_submit'])) {
  $edicaoUsuario = new EditarUsuario();
  $id = $_POST['id'];
  $dados = array(
      'nome' => $_POST['nome'],
      'imagem' => $_POST['imagem'],
      'login' => $_POST['login'],
      'senha' => $_POST['senha']
  );
  $resultado = $edicaoUsuario->editarUsuario($id, $dados);
  if($resultado) {
      header("Location: {$_SERVER['PHP_SELF']}");
      exit();
  } else {
      echo "Erro ao editar usuário.";
  }
}

if(isset($_POST['excluir_usuario'])) {
  $exclusaoUsuario = new ExclusaoUsuario();
  $idUsuario = $_POST['id_usuario'];
  $resultado = $exclusaoUsuario->excluirUsuario($idUsuario);
  if($resultado) {
      header("Location: {$_SERVER['PHP_SELF']}");
      exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard 2</title>
  <link rel="stylesheet" href="./style/style-busca-usuario.scss">
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>
  <?php include 'header.php'; ?>
  <div class="content-wrapper">
    <section class="content">
      <div class="container-table">
        <div class="container-search">
          <h4>Clientes</h4>
          <form method="POST" action="" class="form-apaga">
            <button type="submit"><img src="./img/lupa.png" alt=""></button>
            <input type="text" name="buscar" placeholder="Pesquisar">
          </form>
        </div>
        <div class="container-title">
          <div>
            <span>Id</span>
          </div>
          <div>
            <span>Imagem</span>
          </div>
          <div>
            <span>Nome</span>
          </div>
          <div>
            <span>Login</span>
          </div>
          <div>
            <span>Criado em</span>
          </div>
          <div>
            <span>Editar</span>
          </div>
          <div>
            <span>Excluir</span>
          </div>
        </div>
        <?php
          if ($result && $result->num_rows > 0) {
              while ($linha = $result->fetch_array()) {
        ?>
          <div class="line">
            <div>
              <span><?=$linha['id']?></span>
            </div>
            <div>
              <?php if (!empty($linha['imagem'])): ?>
                  <img src="<?=$linha['imagem']?>" alt="Imagem do Usuário">
              <?php else: ?>
                  <img src="./img/user.png" alt="Imagem Fixa">
              <?php endif; ?>
            </div>
            <div>
              <span><?=$linha['nome']?></span>
            </div>
            <div>
              <span><?=$linha['login']?></span>
            </div>
            <div>
              <span><?=$linha['data']?></span>
            </div>
            <div>
              <form method="POST" action="">
                <input type="hidden" name="id_usuario" value="<?=$linha['id']?>">
                <input type="hidden" name="nome_usuario" value="<?=$linha['nome']?>">
                <input type="hidden" name="imagem_usuario" value="<?=$linha['imagem']?>">
                <input type="hidden" name="login_usuario" value="<?=$linha['login']?>">
                <input type="hidden" name="data" value="<?=$linha['data']?>">
                <button type="submit" name="editar_usuario">
                  <img src="./img/editar.png" alt="">
                </button>
              </form>
            </div>
            <div>
              <form method="POST" action="">
                <input type="hidden" name="id_usuario" value="<?=$linha['id']?>">
                <button type="submit" name="excluir_usuario" onclick="return confirm('Tem certeza que deseja excluir este usuario?');">
                  <img src="./img/excluir.png" class="actions">
                </button>
              </form>
            </div>
          </div>
        <?php
            }
          } else {
              echo "<p>Nenhum usuario encontrado.</p>";
          }
        ?>
        <div class="container-edita" id="container-edita" style="display: none;">
          <form class="content form-edita" method="POST" action="">
            <div>
              <h4>Editar Produto</h4>
              <button class="btn-fechar" type="button">
                <img src="./img/fechar.png" alt="">
              </button>
            </div>
            <input type="hidden" name="id" id="id">
            <input type="text" name="nome" placeholder="Nome" id="nome">
            <input type="text" name="imagem" placeholder="Imagem" id="imagem">
            <input type="text" name="login" placeholder="Login" id="login">
            <input type="password" name="senha" placeholder="Senha" id="senha">
            <button type="submit" name="editar_usuario_submit">Salvar</button>
          </form>
        </div>
      </div>
    </section>
  </div>
</div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnEditar = document.querySelectorAll('[name="editar_usuario"]');
        const btnFechar = document.querySelector('.btn-fechar');
        const containerEdita = document.getElementById('container-edita');

        btnEditar.forEach(function (btn) {
          btn.addEventListener('click', function (event) {
              event.preventDefault();
              const idInput = btn.parentNode.querySelector('[name="id_usuario"]');
              const id = idInput ? idInput.value : null;
              const nomeInput = btn.parentNode.querySelector('[name="nome_usuario"]');
              const nome = nomeInput ? nomeInput.value : null;
              const imagemInput = btn.parentNode.querySelector('[name="imagem_usuario"]');
              const imagem = imagemInput ? imagemInput.value : null;
              const loginInput = btn.parentNode.querySelector('[name="login_usuario"]');
              const login = loginInput ? loginInput.value : null;

              document.getElementById('id').value = id;
              document.getElementById('nome').value = nome;
              document.getElementById('imagem').value = imagem;
              document.getElementById('login').value = login;
              document.getElementById('senha').value = senha;
              containerEdita.style.display = 'flex';
          });
        });

        btnFechar.addEventListener('click', function () {
            containerEdita.style.display = 'none';
        });
    });
  </script>
</body>
</html>