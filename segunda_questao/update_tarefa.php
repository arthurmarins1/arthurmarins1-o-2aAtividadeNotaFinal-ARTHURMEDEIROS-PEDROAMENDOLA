<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $sql = "UPDATE tarefas SET concluida = 1 WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute([':id' => $id]);

    header('Location: index.php');
    exit;
}
?>
