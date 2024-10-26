<?php
include '../config/conexao.php'; // Conexão com o banco de dados

if (isset($_GET['id'])) {
    $id_projeto = $_GET['id'];
    $sql = "DELETE FROM Projetos WHERE id = $id_projeto";
    
    if (mysqli_query($conn, $sql)) {
        header('Location: ../dashboard.php');
    } else {
        echo "Erro ao excluir projeto.";
    }
}
?>
