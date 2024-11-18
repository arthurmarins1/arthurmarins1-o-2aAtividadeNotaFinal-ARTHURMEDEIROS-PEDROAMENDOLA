<?php
require 'database.php';
header('Content-Type: application/json; charset=utf-8');

try {
  $pdo = getDataBaseConnection();
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $delete = $_POST["delete"] ?? null;

    if (!$delete) {
      echo json_encode([
        'status' => 'error',
        'message' => 'O campo ID e obrigatorio'
      ]);
      exit;
    }

    $prepareToDelete = $pdo->prepare("DELETE FROM books WHERE id = :id");
    $prepareToDelete->bindParam(':id', $delete);

    $prepareToDelete->execute();

    echo json_encode([
      'status' => 'success',
      'message' => 'Livro deletado com sucesso'
    ]);
    exit;
  }
} catch (PDOException $e) {
  echo json_encode([
    'status' => 'error',
    'message' => 'Erro no servidor: ' . $e->getMessage()
  ]);
}

exit;