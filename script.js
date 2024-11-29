
async function loadTasks() {
    try {
        const response = await fetch('listar_tarefas.php');
        if (!response.ok) throw new Error('Erro ao carregar tarefas');
        const tasks = await response.json();
        
        document.getElementById("task-list").innerHTML = tasks.map(task => {
            // Converte o custo para número e aplica a classe `bg-warning` se for maior que 1000
            const custo = parseFloat(task.custo);

            // Log de depuração para verificar valores
            //console.log(`Nome: ${task.nome}, Custo: ${task.custo}, Convertido: ${custo}`);

            // Define a classe de cor se o custo for maior que 1000
            const rowClass = !isNaN(custo) && custo >= 1000 ? 'table-info' : '';

        return /*html*/`
            <tr class="${rowClass}">
                <td>${task.nome}</td>
                <td>R$ ${!isNaN(parseFloat(task.custo)) ? parseFloat(task.custo).toFixed(2) : task.custo}</td>
                <td>${formatarData(task.data_limite)}</td>
                <td>
                    <button class="btn btn-outline-secondary btn-sm me-2" onclick="moveTaskUp(${task.id}, 'up')">🔼</button>
                    <button class="btn btn-outline-secondary btn-sm me-2" onclick="moveTaskDown(${task.id}, 'down')">🔽</button>
                    <button class="btn btn-outline-primary btn-sm" onclick="loadTaskToEdit(${task.id})">✏️</button>
                    <button class="btn btn-outline-danger btn-sm" onclick="deleteTask(${task.id})">🗑️</button>
                </td>
                              
            </tr>
    `}).join('');
    } catch (error) {
        console.error("Erro ao carregar tarefas:", error);
    }
}


async function addOrEditTask(event) {
    event.preventDefault();

    const taskId = document.getElementById("task-id").value;
    const formData = new FormData();
    formData.append("nome", document.getElementById("task-name").value);
    formData.append("custo", document.getElementById("task-cost").value);
    formData.append("data_limite", document.getElementById("task-date").value);

    if (taskId) {
        formData.append("id", taskId); // Inclui o ID da tarefa para edição
    }

    const url = taskId ? 'editar_tarefa.php' : 'adicionar_tarefa.php';
    const response = await fetch(url, { method: 'POST', body: formData });

    if (response.ok) {
        closeModal();
        loadTasks(); // Atualiza a lista de tarefas no frontend
    } else {
        console.error('Erro ao salvar tarefa:', response.statusText);
    }
}


async function loadTaskToEdit(taskId) {
    try {
        const response = await fetch(`buscar_tarefa.php?id=${taskId}`);
        const task = await response.json();

        document.getElementById("task-id").value = task.id;
        document.getElementById("task-name").value = task.nome;
        document.getElementById("task-cost").value = task.custo;
        document.getElementById("task-date").value = task.data_limite;

        document.getElementById("modal-title").textContent = "Editar Tarefa";
        showModal();
    } catch (error) {
        console.error("Erro ao buscar detalhes da tarefa:", error);
    }
}


async function deleteTask(taskId) {
    if (!confirm("Tem certeza de que deseja excluir esta tarefa?")) return;

    try {
        const response = await fetch(`excluir_tarefa.php?id=${taskId}`, { method: 'DELETE' });
        const result = await response.json();

        if (result.success) {
            loadTasks();
        } else {
            console.error("Erro ao excluir tarefa:", result.message);
        }
    } catch (error) {
        console.error("Erro na requisição para excluir tarefa:", error);
    }
}

async function moveTaskUp(taskId, direction) {
    try {
        const response = await fetch(`mover_tarefa.php?id=${taskId}&direction=${direction}`, { method: 'POST' });
        const result = await response.json();

        if (result.success) {
            loadTasks(); // Recarrega a lista de tarefas após a mudança de ordem
        } else {
            console.error("Erro ao mover tarefa:", result.message);
        }
    } catch (error) {
        console.error("Erro ao tentar mover tarefa:", error);
    }
}

async function moveTaskDown(taskId, direction) {
    try {
        const response = await fetch(`mover_tarefa.php?id=${taskId}&direction=${direction}`, { method: 'POST' });
        const result = await response.json();

        if (result.success) {
            loadTasks(); // Recarrega a lista de tarefas após a mudança de ordem
        } else {
            console.error("Erro ao mover tarefa:", result.message);
        }
    } catch (error) {
        console.error("Erro ao tentar mover tarefa:", error);
    }
}

function closeModal() {
    const modal = bootstrap.Modal.getInstance(document.getElementById("taskModal"));
    modal.hide();
    document.getElementById("task-form").reset();
    document.getElementById("task-id").value = '';
    document.getElementById("modal-title").textContent = "Adicionar Tarefa";
}

function showModal() {
    const modal = new bootstrap.Modal(document.getElementById("taskModal"));
    modal.show();
}

function formatarData(data) {
    // Extrai diretamente ano, mês e dia da string
    const [ano, mes, dia] = data.split('-');
    return `${dia}/${mes}/${ano}`;
}


// Carrega as tarefas ao inicializar
loadTasks();
