<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $custo = $_POST['custo'];
    $data_limite = $_POST['data_limite'];

    try {
        $stmt = $pdo->prepare("UPDATE tarefas SET nome = :nome, custo = :custo, data_limite = :data_limite WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':custo', $custo);
        $stmt->bindParam(':data_limite', $data_limite);
        
        $stmt->execute();
        
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>
