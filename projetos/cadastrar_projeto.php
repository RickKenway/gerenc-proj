<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config/conexao.php'; // Conexão com o banco de dados

// Teste a conexão com o banco de dados
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Verificar se o usuário está autenticado
if (!isset($_SESSION['id_usuario'])) {
    exit;
}

// Verificar se o método de envio é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar os valores do formulário
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $data_inicio = $_POST['data_inicio'];
    $data_termino = !empty($_POST['data_termino']) ? $_POST['data_termino'] : NULL;
    $id_usuario = $_SESSION['id_usuario'];

    // Verificar se os campos estão preenchidos
    if (empty($nome) || empty($descricao) || empty($data_inicio)) {
        echo "Todos os campos são obrigatórios.<br>";
        exit;
    }

    // Montar a consulta SQL para inserção
    $sql = "INSERT INTO Projetos (nome, descricao, data_inicio, data_termino, id_usuario) 
            VALUES ('$nome', '$descricao', '$data_inicio', ".($data_termino ? "'$data_termino'" : "NULL").", $id_usuario)";
    
    // Executar a inserção no banco de dados
    if (mysqli_query($conn, $sql)) {
        header('Location: ../dashboard.php');
        exit;
    } else {
        echo "Erro ao cadastrar projeto: " . mysqli_error($conn) . "<br>";
    }
} else {
    // Se o método não for POST, exibe o formulário
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastrar Projeto</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <h2>Cadastrar Novo Projeto</h2>
        <form action="cadastrar_projeto.php" method="POST">
            <label for="nome">Nome do Projeto:</label>
            <input type="text" id="nome" name="nome" required><br>

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required></textarea><br>

            <label for="data_inicio">Data de Início:</label>
            <input type="date" id="data_inicio" name="data_inicio" required><br>

            <label for="data_termino">Data de Fim:</label>
            <input type="date" id="data_termino" name="data_termino"><br>

            <button type="submit">Cadastrar</button>
        </form>
    </body>
    </html>
    <?php
}
?>
