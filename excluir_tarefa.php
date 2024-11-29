<?php
header('Content-Type: application/json');
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM tarefas WHERE id = ?");
        $stmt->execute([$id]);

        echo json_encode(["success" => true, "message" => "Tarefa excluída com sucesso"]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Erro ao excluir tarefa: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "ID da tarefa não fornecido"]);
}
?>
