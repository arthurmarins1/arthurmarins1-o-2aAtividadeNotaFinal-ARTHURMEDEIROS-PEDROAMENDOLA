<?php

require 'database.php';
header('Content-Type: application/json; charset=utf-8');

try {
    $pdo = getDataBaseConnection();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"] ?? null;
        $title = $_POST["title"] ?? null;
        $author = $_POST["author"] ?? null;
        $release_date = $_POST["release_date"] ?? null;

        if (!$id || !$title || !$author || !$release_date) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Todos os campos são obrigatórios.'
            ]);
            exit;
        }

        $prepareInsert = $pdo->prepare("INSERT INTO books (id, title, author, release_date)
            VALUES (:id, :title, :author, :release_date)");

        $prepareInsert->bindParam(':id', $id);
        $prepareInsert->bindParam(':title', $title);
        $prepareInsert->bindParam(':author', $author);
        $prepareInsert->bindParam(':release_date', $release_date);

        $prepareInsert->execute();

        echo json_encode([
            'status' => 'success',
            'message' => 'Livro adicionado com sucesso.'
        ]);
        exit;
    } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
        $queryData = $pdo->query("SELECT * FROM books");
        $books = $queryData->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'status' => 'success',
            'message' => 'Livros listados com sucesso.',
            'data' => $books
        ]);
        exit;
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Método HTTP inválido. Use POST ou GET.'
        ]);
        exit;
    }
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Erro no servidor: ' . $e->getMessage()
    ]);
    exit;
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Erro inesperado: ' . $e->getMessage()
    ]);
    exit;
}