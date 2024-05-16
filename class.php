<?php

class ExclusaoProduto
{
    public $conn;

    public function __construct()
    {
        $db = new banco;
        $this->conn = $db->conn;
    }

    public function excluirProduto($idProduto)
    {
        $sql = "UPDATE produto SET apagado = 1 WHERE id = $idProduto";
        $resultado = $this->conn->query($sql);
        return $resultado;
    }
}

class FiltroProduto
{
    public $conn;

    public function __construct()
    {
        $db = new banco;
        $this->conn = $db->conn;
    }

    public function filtrarProdutos($filtro)
    {
        $sql = "SELECT * FROM produto WHERE nome LIKE '%" . $filtro . "%'";
        $resultado = $this->conn->query($sql);
        return $resultado;
    }
}

class EditarProduto
{
    public $conn;

    public function __construct()
    {
        $db = new banco;
        $this->conn = $db->conn;
    }

    public function editarProduto($id, $dados)
    {
        $nome = $this->conn->real_escape_string($dados['nome']);
        $imagem = $this->conn->real_escape_string($dados['imagem']);
        $valor = $this->conn->real_escape_string($dados['valor']);
        $quantidade = $this->conn->real_escape_string($dados['quantidade']);
        $sql = "UPDATE produto SET nome=?, imagem=?, valor=?, quantidade=? WHERE id=?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssi", $nome, $imagem, $valor, $quantidade, $id);
        
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Erro ao editar produto: " . $stmt->error;
            return false;
        }
    }
}

class produto
{
    public $conn;
    
    public function __construct()
    {
        $db = new banco;
        $this->conn = $db->conn;
    }

    public function listar_produtos()
    {
        $sql = "SELECT * FROM produto WHERE apagado = 0";
        $resultado = $this->conn->query($sql);
        return $resultado;
    }
}


class funcionario
{
    public $conn;
    public function __construct()
    {
        $db = new banco;
        $this->conn = $db->conn;
    }

    public function validar($inputData)
    {
        $login = $inputData['login'];
        $senha = $inputData['senha'];
        

        $sql = "select * from usuario where login='" . $login . "' and senha='" . $senha . "'";
        $result = $this->conn->query($sql);
        $linha = $result->fetch_array();
        $result = $result->num_rows;

        if ($result == 1) {
            $_SESSION["nome"] = $linha['nome'];
            return true;
        } else {
            return false;
        }
    }

    public function criarUsuario($inputData)
{
    $login = $inputData['login'];
    $senha = $inputData['senha'];
    $nome = $inputData['nome'];
   // $data_cad = $inputData['data_cad'];
    date_default_timezone_set('America/Sao_Paulo');
    $tempo = date("Y-m-d H:i:s");
    //$data_cad_formatada = date('Y-m-d H:i:s', strtotime($data_cad));

    $sql = "INSERT INTO usuario (login, senha, nome, data_cad) VALUES ('$login', '$senha', '$nome', '$tempo')";
    $result = $this->conn->query($sql);

    if ($result == 1) {
        return true;
    } else {
        return false;
    }
}
}
class Usuario {
    public $conn;

    public function __construct() {
        $db = new banco;
        $this->conn = $db->conn;
    }

    public function listar_usuarios() {
        $sql = "SELECT * FROM usuario WHERE apagado = 0";
        $resultado = $this->conn->query($sql);
        return $resultado;
    }
}

class ExclusaoUsuario
{
    public $conn;

    public function __construct()
    {
        $db = new banco;
        $this->conn = $db->conn;
    }

    public function excluirUsuario($idUsuario)
    {
        $sql = "UPDATE usuario SET apagado = 1 WHERE id = $idUsuario";
        $resultado = $this->conn->query($sql);
        return $resultado;
    }
}

class FiltroUsuario
{
    public $conn;

    public function __construct()
    {
        $db = new banco;
        $this->conn = $db->conn;
    }

    public function filtrarUsuarios($filtro)
    {
        $sql = "SELECT * FROM usuario WHERE nome LIKE '%" . $filtro . "%'";
        $resultado = $this->conn->query($sql);
        return $resultado;
    }
}

class EditarUsuario
{
    public $conn;

    public function __construct()
    {
        $db = new banco;
        $this->conn = $db->conn;
    }
    public function editarUsuario($id, $dados)
    {
        $nome = $this->conn->real_escape_string($dados['nome']);
        $imagem = $this->conn->real_escape_string($dados['imagem']);
        $login = $this->conn->real_escape_string($dados['login']);
        $senha = $this->conn->real_escape_string($dados['senha']);
        $sql = "UPDATE usuario SET nome=?, imagem=?, login=?, senha=? WHERE id=?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssi", $nome, $imagem, $login, $senha, $id);
        
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Erro ao editar usuario: " . $stmt->error;
            return false;
        }
    }
}
