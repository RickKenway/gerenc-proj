<?php
session_start();
include '../config/conexao.php'; // Conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM Usuarios WHERE email = '$email' AND senha = '$senha'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['id_usuario'] = $user['id'];
        $_SESSION['nome'] = $user['nome'];
        header('Location: ../dashboard.php');
    } else {
        echo "E-mail ou senha incorretos.";
    }
}
?>
