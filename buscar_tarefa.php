<?php
header('Content-Type: application/json');
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $stmt = $pdo->prepare("SELECT * FROM tarefas WHERE id = ?");
    $stmt->execute([$id]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($task) {
        echo json_encode($task);
    } else {
        echo json_encode(["success" => false, "message" => "Tarefa não encontrada"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "ID da tarefa não fornecido"]);
}
?>
