<?php
require 'database.php';

$query = "SELECT * FROM tarefas ORDER BY concluida ASC, data_vencimento ASC";
$tarefas = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #2c3e50; }
        form { margin-bottom: 20px; }
        ul { list-style: none; padding: 0; }
        li { margin-bottom: 15px; }
        .concluida { text-decoration: line-through; color: gray; }
        .tarefa-titulo { font-weight: bold; }
        button { margin-left: 10px; }
    </style>
</head>
<body>
    <h1>Gerenciador de Tarefas</h1>

    <form action="add_tarefa.php" method="POST">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" placeholder="Título da tarefa" required>
        <br><br>
        <label for="descricao">Descrição:</label>
        <textarea name="descricao" id="descricao" placeholder="Descrição da tarefa (opcional)"></textarea>
        <br><br>
        <label for="data_vencimento">Data de Vencimento:</label>
        <input type="date" name="data_vencimento" id="data_vencimento" required>
        <br><br>
        <button type="submit">Adicionar Tarefa</button>
    </form>

    <h2>Tarefas Pendentes</h2>
    <ul>
        <?php foreach ($tarefas as $tarefa): ?>
            <?php if ($tarefa['concluida'] == 0): ?>
                <li>
                    <span class="tarefa-titulo"><?= htmlspecialchars($tarefa['titulo']) ?></span><br>
                    <?= htmlspecialchars($tarefa['descricao']) ?><br>
                    <small>Data de Vencimento: <?= htmlspecialchars($tarefa['data_vencimento']) ?></small>
                    <br>
                    <form action="update_tarefa.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($tarefa['id']) ?>">
                        <button type="submit">Concluir</button>
                    </form>
                    <form action="delete_tarefa.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($tarefa['id']) ?>">
                        <button type="submit">Excluir</button>
                    </form>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>

    <h2>Tarefas Concluídas</h2>
    <ul>
        <?php foreach ($tarefas as $tarefa): ?>
            <?php if ($tarefa['concluida'] == 1): ?>
                <li class="concluida">
                    <span class="tarefa-titulo"><?= htmlspecialchars($tarefa['titulo']) ?></span><br>
                    <?= htmlspecialchars($tarefa['descricao']) ?><br>
                    <small>Data de Vencimento: <?= htmlspecialchars($tarefa['data_vencimento']) ?></small>
                    <br>
                    <form action="delete_tarefa.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($tarefa['id']) ?>">
                        <button type="submit">Excluir</button>
                    </form>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</body>
</html>
