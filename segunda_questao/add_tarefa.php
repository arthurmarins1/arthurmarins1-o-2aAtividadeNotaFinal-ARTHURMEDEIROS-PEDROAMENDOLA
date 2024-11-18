<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $descricao = trim($_POST['descricao']);
    $data_vencimento = $_POST['data_vencimento'];

    if (!empty($titulo) && !empty($data_vencimento)) {
        $query = "INSERT INTO tarefas (titulo, descricao, data_vencimento) VALUES (:titulo, :descricao, :data_vencimento)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            ':titulo' => htmlspecialchars($titulo),
            ':descricao' => htmlspecialchars($descricao),
            ':data_vencimento' => $data_vencimento
        ]);
    }
    header('Location: index.php');
    exit;
}
?>
