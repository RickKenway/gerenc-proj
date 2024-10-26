<?php
$servername = "localhost";
$username = "root";  // Ajuste conforme necessário
$password = "";      // Ajuste conforme necessário
$dbname = "gerenciamentoprojetos"; // Nome do banco de dados

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
