<?php
try {
    // Estabelecendo a conexão com o banco de dados SQLite
    $pdo = new PDO('sqlite:C:\PROGRAMAS\XAMPP\htdocs\listatarefas\lista_tarefas.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Para ver erros mais claros
} catch (PDOException $e) {
    echo "Erro ao conectar: " . $e->getMessage();
    exit;
}
?>

