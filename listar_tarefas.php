<?php
include 'db.php';

$stmt = $pdo->query("SELECT * FROM tarefas ORDER BY ordem");
$tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($tarefas);

?>
