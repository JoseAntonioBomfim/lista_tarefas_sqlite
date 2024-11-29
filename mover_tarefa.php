<?php
include 'db.php';

$id = $_GET['id'];
$direction = $_GET['direction'];

// Obtém a tarefa atual e sua ordem
$stmt = $pdo->prepare("SELECT id, ordem FROM tarefas WHERE id = :id");
$stmt->execute(['id' => $id]);
$tarefa = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tarefa) {
    echo json_encode(['success' => false, 'message' => 'Tarefa não encontrada']);
    exit;
}

$ordemAtual = $tarefa['ordem'];

// Verifica a ordem mínima e máxima
$stmt = $pdo->query("SELECT MIN(ordem) AS min_ordem, MAX(ordem) AS max_ordem FROM tarefas");
$ordens = $stmt->fetch(PDO::FETCH_ASSOC);
$minOrdem = $ordens['min_ordem'];
$maxOrdem = $ordens['max_ordem'];

// Define a nova ordem com base na direção, mas verifica os limites
if ($direction === 'up' && $ordemAtual > $minOrdem) {
    $novaOrdem = $ordemAtual - 1;
} elseif ($direction === 'down' && $ordemAtual < $maxOrdem) {
    $novaOrdem = $ordemAtual + 1;
} else {
    // Se estiver no limite, não faz a movimentação
    echo json_encode(['success' => false, 'message' => 'Movimento inválido']);
    exit;
}

// Atualiza a posição da tarefa que está na nova posição temporariamente
$stmt = $pdo->prepare("UPDATE tarefas SET ordem = -1 WHERE ordem = :novaOrdem");
$stmt->execute(['novaOrdem' => $novaOrdem]);

// Atualiza a ordem da tarefa desejada
$stmt = $pdo->prepare("UPDATE tarefas SET ordem = :novaOrdem WHERE id = :id");
$success = $stmt->execute(['novaOrdem' => $novaOrdem, 'id' => $id]);

// Restaura a ordem da tarefa temporária para o valor anterior da tarefa movida
$stmt = $pdo->prepare("UPDATE tarefas SET ordem = :ordemAtual WHERE ordem = -1");
$stmt->execute(['ordemAtual' => $ordemAtual]);

echo json_encode(['success' => $success]);
?>
