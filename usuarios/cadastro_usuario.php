<?php
include '../config/conexao.php'; // Conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "INSERT INTO Usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
    if (mysqli_query($conn, $sql)) {
        echo "Usuário cadastrado com sucesso.";
    } else {
        echo "Erro ao cadastrar usuário.";
    }
}
?>
