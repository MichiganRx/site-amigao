<?php
session_start();
require_once './banco.php';
require_once './class.php';

$db = new banco;

if(isset($_POST['buscar'])) {
    $filtroProduto = new FiltroProduto();
    $result = $filtroProduto->filtrarProdutos($_POST['buscar']);
} else {
    $produto = new produto;
    $result = $produto->listar_produtos();
}

if(isset($_POST['excluir_produto'])) {
  $exclusaoProduto = new ExclusaoProduto();
  $idProduto = $_POST['id_produto'];
  $resultado = $exclusaoProduto->excluirProduto($idProduto);
  if($resultado) {
      header("Location: {$_SERVER['PHP_SELF']}");
      exit();
  }
}

if(isset($_POST['editar_produto_submit'])) {
  $edicaoProduto = new EditarProduto();
  $id = $_POST['id_produto_edit'];
  $dados = array(
      'nome' => $_POST['nome_produto'],
      'imagem' => $_POST['imagem_produto'],
      'valor' => $_POST['valor_produto'],
      'quantidade' => $_POST['quantidade_produto']
  );
  var_dump($dados);
  $resultado = $edicaoProduto->editarProduto($id, $dados);
  if($resultado) {
      header("Location: {$_SERVER['PHP_SELF']}");
      exit();
  }
}

if(isset($_POST['inserir_produto_submit'])) {
  $edicaoProduto = new InserirProduto();
  $dados = array(
      'nome' => $_POST['nome_produto'],
      'imagem' => $_POST['imagem_produto'],
      'valor' => $_POST['valor_produto'],
      'quantidade' => $_POST['quantidade_produto']
  );
  var_dump($dados);
  $resultado = $edicaoProduto->inserirProduto($dados); // Remova o $id daqui
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
  <link rel="stylesheet" href="./style/style-busca.scss">
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
          <div>
            <h4>Produtos</h4>
            <form method="POST" action="">
              <input type="hidden" name="id_produto" value="<?=$linha['id']?>">
              <input type="hidden" name="nome_produto" value="<?=$linha['nome']?>">
              <input type="hidden" name="imagem_produto" value="<?=$linha['imagem']?>">
              <input type="hidden" name="valor_produto" value="<?=$linha['valor']?>">
              <input type="hidden" name="quantidade_produto" value="<?=$linha['quantidade']?>">
              <button type="submit" name="adicionar_produto" class="add-produto">
                <span>Novo Produto</span>
                <img src="./img/botao-adicionar.png" alt="">
              </button>
            </form>
          </div>
          <form method="POST" action="">
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
            <span>Preço</span>
          </div>
          <div>
            <span>Quantidade</span>
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
                <?php if (isset($linha['imagem']) && !empty($linha['imagem'])): ?>
                    <img src="<?=$linha['imagem']?>" alt="Imagem do Produto">
                <?php else: ?>
                    <img src="img/indisponivel.png" alt="Imagem do Produto">
                <?php endif; ?>
            </div>
            <div>
              <span><?=$linha['nome']?></span>
            </div>
            <div>
              <span><b>R$  </b><?=$linha['valor']?></span>
            </div>
            <div>
              <span><?=$linha['quantidade']?></span>
            </div>
            <div>
              <form method="POST" action="">
                <input type="hidden" name="id_produto" value="<?=$linha['id']?>">
                <input type="hidden" name="nome_produto" value="<?=$linha['nome']?>">
                <input type="hidden" name="imagem_produto" value="<?=$linha['imagem']?>">
                <input type="hidden" name="valor_produto" value="<?=$linha['valor']?>">
                <input type="hidden" name="quantidade_produto" value="<?=$linha['quantidade']?>">
                <button type="submit" name="editar_produto">
                  <img src="./img/editar.png" alt="">
                </button>
              </form>
            </div>
            <div>
              <form method="POST" action="">
                <input type="hidden" name="id_produto" value="<?=$linha['id']?>">
                <button type="submit" name="excluir_produto" onclick="return confirm('Tem certeza que deseja excluir este produto?');">
                  <img src="./img/excluir.png" class="actions">
                </button>
              </form>
            </div>
          </div>
        <?php
            }
          } else {
              echo "<p>Nenhum produto encontrado.</p>";
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
            <input type="hidden" name="id_produto_edit" id="id_produto_edit">
            <input type="text" name="nome_produto" placeholder="Nome" id="nome_produto_edit">
            <input type="text" name="imagem_produto" placeholder="Imagem" id="imagem_produto_edit">
            <input type="text" name="valor_produto" placeholder="Preço" id="valor_produto_edit">
            <input type="text" name="quantidade_produto" placeholder="Quantidade" id="quantidade_produto_edit">
            <button type="submit" name="editar_produto_submit">Salvar</button>
          </form>
        </div>
        <div class="container-edita" id="container-cadastra" style="display: none;">
          <form class="content form-edita" method="POST" action="">
            <div>
              <h4>Adicionar Produto</h4>
              <button class="btn-fechar" type="button" id="btn-fechar-add">
                <img src="./img/fechar.png" alt="">
              </button>
            </div>
            <input type="hidden" name="id_produto_edit" id="id_produto_edit">
            <input type="text" name="nome_produto" placeholder="Nome" id="nome_produto_edit">
            <input type="text" name="imagem_produto" placeholder="Imagem" id="imagem_produto_edit">
            <input type="text" name="valor_produto" placeholder="Preço" id="valor_produto_edit">
            <input type="text" name="quantidade_produto" placeholder="Quantidade" id="quantidade_produto_edit">
            <button type="submit" name="inserir_produto_submit">Salvar</button>
          </form>
        </div>
      </div>
    </section>
  </div>
</div>
<script>
 document.addEventListener('DOMContentLoaded', function () {
    const btnEditar = document.querySelectorAll('[name="editar_produto"]');
    const btnFechar = document.querySelector('.btn-fechar');
    const containerEdita = document.getElementById('container-edita');

    btnEditar.forEach(function (btn) {
        btn.addEventListener('click', function (event) {
            event.preventDefault();
            const idProduto = btn.parentNode.querySelector('[name="id_produto"]').value;
            const nomeProduto = btn.parentNode.querySelector('[name="nome_produto"]').value;
            const imagemProduto = btn.parentNode.querySelector('[name="imagem_produto"]').value;
            const valorProduto = btn.parentNode.querySelector('[name="valor_produto"]').value;
            const quantidadeProduto = btn.parentNode.querySelector('[name="quantidade_produto"]').value;

            document.getElementById('id_produto_edit').value = idProduto;
            document.getElementById('nome_produto_edit').value = nomeProduto;
            document.getElementById('imagem_produto_edit').value = imagemProduto;
            document.getElementById('valor_produto_edit').value = valorProduto;
            document.getElementById('quantidade_produto_edit').value = quantidadeProduto;

            containerEdita.style.display = 'flex';
        });
    });

    btnFechar.addEventListener('click', function () {
        containerEdita.style.display = 'none';
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const btnEditar = document.querySelectorAll('[name="adicionar_produto"]');
    const btnFechar = document.getElementById('btn-fechar-add');
    const containerEdita = document.getElementById('container-cadastra');

    btnEditar.forEach(function (btn) {
        btn.addEventListener('click', function (event) {
            event.preventDefault();
            const idProduto = btn.parentNode.querySelector('[name="id_produto"]').value;
            const nomeProduto = btn.parentNode.querySelector('[name="nome_produto"]').value;
            const imagemProduto = btn.parentNode.querySelector('[name="imagem_produto"]').value;
            const valorProduto = btn.parentNode.querySelector('[name="valor_produto"]').value;
            const quantidadeProduto = btn.parentNode.querySelector('[name="quantidade_produto"]').value;

            document.getElementById('id_produto_edit').value = idProduto;
            document.getElementById('nome_produto_edit').value = nomeProduto;
            document.getElementById('imagem_produto_edit').value = imagemProduto;
            document.getElementById('valor_produto_edit').value = valorProduto;
            document.getElementById('quantidade_produto_edit').value = quantidadeProduto;

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
