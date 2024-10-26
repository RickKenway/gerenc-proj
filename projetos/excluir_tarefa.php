<?php
include '../config/conexao.php'; // Conexão com o banco de dados

// Verifica se o ID da tarefa e do projeto foram passados pela URL
if (isset($_GET['id_tarefa']) && isset($_GET['id_projeto'])) {
    $id_tarefa = $_GET['id_tarefa'];
    $id_projeto = $_GET['id_projeto']; // Captura o ID do projeto

    // Montar a consulta SQL para exclusão
    $sql = "DELETE FROM Tarefas WHERE id = $id_tarefa";

    // Executar a exclusão no banco de dados
    if (mysqli_query($conn, $sql)) {
        echo "Tarefa excluída com sucesso!<br>";
        // Redirecionar para a página de visualização das tarefas
        header("Location: visualizar_tarefas.php?id_projeto=$id_projeto");
        exit;
    } else {
        echo "Erro ao excluir tarefa: " . mysqli_error($conn);
    }
} else {
    echo "ID da tarefa ou ID do projeto não fornecido.";
    exit;
}
?>
