<?php
// Conectar ao banco de dados SQLite
$db = new PDO('sqlite:C:\PROGRAMAS\XAMPP\htdocs\listatarefas\lista_tarefas.db');

// Consultar todos os registros da tabela Tarefas
$query = "SELECT * FROM Tarefas";
$result = $db->query($query);

// Verificar se há registros
if ($result) {
    // Exibir os dados de cada tarefa
    foreach ($result as $row) {
        echo "ID: " . $row['id'] . "<br>";
        echo "Nome: " . $row['nome'] . "<br>";
        echo "Custo: " . $row['custo'] . "<br>";
        echo "Data Limite: " . $row['data_limite'] . "<br>";
        echo "Ordem: " . $row['ordem'] . "<br><br>";
    }
} else {
    echo "Nenhuma tarefa encontrada.";
}

// Fechar a conexão
$db = null;
?>
