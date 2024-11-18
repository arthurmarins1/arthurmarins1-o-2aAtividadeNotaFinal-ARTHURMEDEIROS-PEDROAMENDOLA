<?php
try {
    $db = new PDO('sqlite:todo_list.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("
        CREATE TABLE IF NOT EXISTS tarefas (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            titulo TEXT NOT NULL,
            descricao TEXT,
            data_vencimento DATE,
            concluida INTEGER DEFAULT 0
        )
    ");
} catch (PDOException $e) {
    echo "Erro ao conectar no banco de dados: " . $e->getMessage();
    exit;
}
?>
