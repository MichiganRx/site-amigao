<?php



session_start();
include('banco.php');
include('class.php');
$db = new banco;

//if (isset($_SESSION['username'])) {



if (isset($_POST['login'])) {
    $inputData = [   
        'login' => mysqli_real_escape_string($db->conn, $_POST['login']),
        'senha' => mysqli_real_escape_string($db->conn, $_POST['senha']),
        'nome' => mysqli_real_escape_string($db->conn, $_POST['nome'])        
    ];


/*
    $senha = $_POST['senha'];
    $senha_confirma = $_POST['senha_confirma'];

    if ($senha <> $senha_confirma) {
        echo "Senhas diferentes";
        header("location: cadastro_usuario.php");
    } else  if (($senha == $senha_confirma) and ($senha != "")) {
        echo "tudo certo";
        $funcionario = new funcionario;
        $result = $funcionario->criar($inputData);
    } else if ($senha == " ") {
        echo "ta vazio ze";
        header("location: cadastro_usuario.php");
        return false;
    } else {
        echo "para de ser burro'";
        header("location: cadastro_usuario.php");
        return false;
    }

    //print_r($result);
*/

$funcionario = new funcionario;
$retorno = $funcionario->criarUsuario($inputData);



    if ($retorno) {
        $_SESSION['message'] = "Cadastro ok - bem vindo " . $_POST['nome'];
        header("location: login/login.html?c=1");
        exit(0);
    } else {
        $_SESSION['message'] = "errou BB";
        header("location: cadastro.html?c=2");
        exit(0);
    }
} else {
    $_SESSION['message'] = "Tu ta tentando acessar direto =)";
    //header("location: cadastro_usuario.php");
    exit(0);
}
/*}else{
    //header("location: index.php");
}
*/