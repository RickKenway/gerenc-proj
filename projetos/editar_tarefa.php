<?php
include '../config/conexao.php'; // Conexão com o banco de dados

// Verifica se o ID da tarefa foi passado pela URL
if (isset($_GET['id_tarefa'])) {
    $id_tarefa = $_GET['id_tarefa'];

    // Busca a tarefa no banco de dados
    $sql = "SELECT * FROM Tarefas WHERE id = $id_tarefa";
    $result = mysqli_query($conn, $sql);

    // Verifica se a tarefa foi encontrada
    if (mysqli_num_rows($result) == 1) {
        $tarefa = mysqli_fetch_assoc($result);
    } else {
        echo "Tarefa não encontrada.";
        exit;
    }
} else {
    echo "ID da tarefa não fornecido.";
    exit;
}

// Habilitar exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Processar a edição da tarefa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $descricao = $_POST['descricao'];
    $status = $_POST['status'];
    $data_inicio = $_POST['data_inicio'];
    $data_termino = !empty($_POST['data_termino']) ? $_POST['data_termino'] : NULL;

    // Montar a consulta SQL para atualização
    $sql_update = "UPDATE Tarefas SET descricao = '$descricao', status = '$status', 
                   data_inicio = '$data_inicio', data_termino = " . ($data_termino ? "'$data_termino'" : "NULL") . " 
                   WHERE id = $id_tarefa";

    // Executar a atualização no banco de dados
    if (mysqli_query($conn, $sql_update)) {
        echo "Tarefa atualizada com sucesso!";
        header("Location: visualizar_tarefas.php?id_projeto=" . $tarefa['id_projeto']);
        exit;
    } else {
        echo "Erro ao atualizar tarefa: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarefa</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Editar Tarefa</h2>
    <form action="editar_tarefa.php?id_tarefa=<?php echo $id_tarefa; ?>" method="POST">
        <label for="descricao">Descrição da Tarefa:</label>
        <textarea id="descricao" name="descricao" required><?php echo $tarefa['descricao']; ?></textarea><br>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="Pendente" <?php echo ($tarefa['status'] == 'Pendente') ? 'selected' : ''; ?>>Pendente</option>
            <option value="Em andamento" <?php echo ($tarefa['status'] == 'Em andamento') ? 'selected' : ''; ?>>Em andamento</option>
            <option value="Concluída" <?php echo ($tarefa['status'] == 'Concluída') ? 'selected' : ''; ?>>Concluída</option>
        </select><br>

        <label for="data_inicio">Data de Início:</label>
        <input type="date" id="data_inicio" name="data_inicio" value="<?php echo $tarefa['data_inicio']; ?>" required><br>

        <label for="data_termino">Data de Término:</label>
        <input type="date" id="data_termino" name="data_termino" value="<?php echo $tarefa['data_termino']; ?>"><br>

        <button type="submit">Salvar Alterações</button>
    </form>

    <br><a href="visualizar_tarefas.php?id_projeto=<?php echo $tarefa['id_projeto']; ?>">Voltar</a>
</body>
</html>
