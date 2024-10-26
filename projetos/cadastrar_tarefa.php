<?php
include '../config/conexao.php'; // Conexão com o banco de dados

// Habilitar exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar se o método de envio é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar os valores do formulário
    $descricao = $_POST['descricao'];
    $status = $_POST['status'];
    $data_inicio = $_POST['data_inicio'];
    $data_termino = !empty($_POST['data_termino']) ? $_POST['data_termino'] : NULL;
    $id_projeto = $_POST['id_projeto'];

    // Verificar se os campos estão preenchidos
    if (empty($descricao) || empty($status) || empty($data_inicio)) {
        echo "Todos os campos são obrigatórios.<br>";
        exit;
    } else {
        echo "Descrição da Tarefa: $descricao<br>";
        echo "Status: $status<br>";
        echo "Data de Início: $data_inicio<br>";
        echo "Data de Fim: $data_termino<br>";
    }

    // Montar a consulta SQL para inserção
    $sql = "INSERT INTO Tarefas (descricao, status, data_inicio, data_termino, id_projeto) 
            VALUES ('$descricao', '$status', '$data_inicio', ".($data_termino ? "'$data_termino'" : "NULL").", $id_projeto)";
    
    // Executar a inserção no banco de dados
    if (mysqli_query($conn, $sql)) {
        echo "Tarefa cadastrada com sucesso!<br>";
        header("Location: visualizar_tarefas.php?id_projeto=$id_projeto");
        exit;
    } else {
        echo "Erro ao cadastrar tarefa: " . mysqli_error($conn) . "<br>";
    }
} else {
    // Se o método não for POST, exibe o formulário
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastrar Tarefa</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <h2>Cadastrar Nova Tarefa</h2>
        <form action="cadastrar_tarefa.php" method="POST">
            <label for="descricao">Descrição da Tarefa:</label>
            <textarea id="descricao" name="descricao" required></textarea><br>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Pendente">Pendente</option>
                <option value="Em andamento">Em andamento</option>
                <option value="Concluída">Concluída</option>
            </select><br>

            <label for="data_inicio">Data de Início:</label>
            <input type="date" id="data_inicio" name="data_inicio" required><br>

            <label for="data_termino">Data de Fim:</label>
            <input type="date" id="data_termino" name="data_termino"><br>

            <input type="hidden" name="id_projeto" value="<?php echo $_GET['id_projeto']; ?>"><!-- Captura o ID do projeto -->

            <button type="submit">Cadastrar</button>
        </form>
    </body>
    </html>
    <?php
}
?>
