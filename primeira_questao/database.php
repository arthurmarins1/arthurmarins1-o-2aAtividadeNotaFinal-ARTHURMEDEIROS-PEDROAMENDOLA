<?php


function getDataBaseConnection() {
  try {
    $pdo = new PDO('sqlite:'.__DIR__.'/bookstore');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE TABLE IF NOT EXISTS books (
            id INTEGER PRIMARY KEY ,
            title TEXT NOT NULL,
            author TEXT NOT NULL,
            release_date TEXT NOT NULL
    )";

    $pdo -> exec($sql);
    return $pdo;

  } catch ( PDOException $e ) {
    echo $e->getMessage();
  }
}
?>