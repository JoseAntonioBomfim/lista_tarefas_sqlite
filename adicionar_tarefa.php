<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
header('Content-Type: application/json');
include 'db.php';

if (isset($_POST['nome'], $_POST['custo'], $_POST['data_limite'])) {
    $nome = $_POST['nome'];
    $custo = $_POST['custo'];
    $data_limite = $_POST['data_limite'];

    $stmt = $pdo->query("SELECT MAX(ordem) as max_ordem FROM tarefas");
    $row = $stmt->fetch();
    $nova_ordem = ($row['max_ordem'] ?? 0) + 1;

    try {
        $sql = "INSERT INTO tarefas (nome, custo, data_limite, ordem) VALUES (?,?,?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $custo, $data_limite, $nova_ordem]);

        echo json_encode(["success" => true, "message" => "Tarefa adicionada com sucesso!"]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Erro ao adicionar tarefa: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Erro: Dados incompletos para adicionar a tarefa."]);
}
?>
