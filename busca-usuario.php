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
          <h4>Produtos</h4>
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
              <img src="<?=$linha['imagem']?>" alt="Imagem do Produto">
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
              <button>
                <img src="./img/editar.png" alt="">
              </button>
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
      </div>
    </section>
  </div>
</div>
</body>
</html>
