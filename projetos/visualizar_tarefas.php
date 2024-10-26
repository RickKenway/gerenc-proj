<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: index.html');
    exit;
}
include '../config/conexao.php'; // Conexão com o banco de dados

// Verifica se o ID do projeto foi passado pela URL
if (isset($_GET['id_projeto'])) {
    $id_projeto = $_GET['id_projeto'];

    // Buscar informações do projeto
    $sql_projeto = "SELECT * FROM Projetos WHERE id = $id_projeto";
    $result_projeto = mysqli_query($conn, $sql_projeto);
    $projeto = mysqli_fetch_assoc($result_projeto);

    // Exibir detalhes do projeto
    if ($projeto) {
        // Início do HTML
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Tarefas do Projeto</title>
            <link rel="stylesheet" href="../css/style.css"> <!-- Caminho do arquivo CSS -->
        </head>
        <body>
            <header style="background-color: #28a745; color: white; padding: 20px; display: flex; justify-content: space-between; align-items: center;">
                <h2>Tarefas do Projeto: <?php echo $projeto['nome']; ?></h2>
                <a href='usuarios/logout.php' style="color: blue;">Sair</a>
            </header>

            <main>
                <p><strong>Descrição:</strong> <?php echo $projeto['descricao']; ?></p>
                <p><strong>Data de Início:</strong> <?php echo $projeto['data_inicio']; ?></p>
                <p><strong>Data de Término:</strong> <?php echo ($projeto['data_termino'] ? $projeto['data_termino'] : 'Não definido'); ?></p>

                <h3>Tarefas</h3>
                <?php
                // Buscar tarefas do projeto
                $sql_tarefas = "SELECT * FROM Tarefas WHERE id_projeto = $id_projeto";
                $result_tarefas = mysqli_query($conn, $sql_tarefas);

                // Exibir tarefas
                if (mysqli_num_rows($result_tarefas) > 0) {
                    echo "<table border='1'>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Descrição</th>
                                    <th>Status</th>
                                    <th>Data de Início</th>
                                    <th>Data de Término</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>";
                    while ($tarefa = mysqli_fetch_assoc($result_tarefas)) {
                        echo "<tr>";
                        echo "<td>" . $tarefa['id'] . "</td>";
                        echo "<td>" . $tarefa['descricao'] . "</td>";
                        echo "<td>" . $tarefa['status'] . "</td>";
                        echo "<td>" . $tarefa['data_inicio'] . "</td>";  // Exibir data de início
                        echo "<td>" . ($tarefa['data_termino'] ? $tarefa['data_termino'] : 'Não definido') . "</td>";  // Exibir data de término
                        echo "<td>
                                <a href='editar_tarefa.php?id_tarefa=" . $tarefa['id'] . "'>Editar</a>
                                | <a href='excluir_tarefa.php?id_tarefa=" . $tarefa['id'] . "&id_projeto=" . $id_projeto . "'>Excluir</a>
                              </td>";
                        echo "</tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "Nenhuma tarefa encontrada.";
                }

                // Links para voltar e cadastrar nova tarefa
                echo "<br><a href='../dashboard.php'>Voltar</a>";
                echo "<br><a href='cadastrar_tarefa.php?id_projeto=$id_projeto' class='cadastrar-btn'>Cadastrar Nova Tarefa +</a>";
                ?>
            </main>
        </body>
        </html>
        <?php
    } else {
        echo "Projeto não encontrado.<br>";
        echo "<a href='../dashboard.php'>Voltar</a>";
        exit;
    }
} else {
    echo "ID do projeto não fornecido.";
    exit;
}
?>
