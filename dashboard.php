<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: index.html');
    exit;
}
include 'config/conexao.php'; // Conexão com o banco de dados

$id_usuario = $_SESSION['id_usuario'];

$sql = "SELECT * FROM Projetos WHERE id_usuario = $id_usuario";
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header style="background-color: #28a745; color: white; padding: 20px; display: flex; justify-content: space-between; align-items: center;">
    <h2>Bem-vindo, <?php echo $_SESSION['nome']; ?></h2>
    <a href='usuarios/logout.php' style="color: blue;">Sair</a>
</header>


    <main>
        <h3>Seus Projetos</h3>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome do Projeto</th>
                        <th>Descrição</th>
                        <th>Data de Início</th>
                        <th>Data de Término</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($projeto = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $projeto['id']; ?></td>
                            <td><?php echo $projeto['nome']; ?></td>
                            <td><?php echo $projeto['descricao']; ?></td>
                            <td><?php echo $projeto['data_inicio']; ?></td>
                            <td><?php echo ($projeto['data_termino'] ? $projeto['data_termino'] : 'Não definido'); ?></td>
                            <td>
                                <a href='projetos/visualizar_tarefas.php?id_projeto=<?php echo $projeto['id']; ?>'>Visualizar Tarefas</a> |
                                <a href='projetos/excluir_projeto.php?id=<?php echo $projeto['id']; ?>'>Excluir Projeto</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum projeto encontrado.</p>
        <?php endif; ?>

        <a href="projetos/cadastrar_projeto.php" class="cadastrar-btn">Cadastrar Novo Projeto +</a>
    </main>
</body>
</html>
