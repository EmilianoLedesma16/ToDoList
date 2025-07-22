document.addEventListener('DOMContentLoaded', () => {
    const addTaskBtn = document.getElementById('add-task-btn');  // Cambiado a tu ID real
    const taskInput = document.getElementById('task-input');
    const taskList = document.getElementById('task-list');      // Cambiado a tu ID real

    // Función para cargar tareas
    async function loadTasks() {
        try {
            const response = await fetch('api/get_task.php');
            if (!response.ok) throw new Error("Error al cargar tareas");
            const tasks = await response.json();
            taskList.innerHTML = tasks.map(task => `
                <li>${task.text}</li>
            `).join('');
        } catch (error) {
            console.error("Error:", error);
        }
    }

    // Añadir tarea (ahora con el botón, no con el formulario)
    addTaskBtn.addEventListener('click', async () => {
        if (!taskInput.value.trim()) return;  // Evitar tareas vacías

        try {
            const response = await fetch('api/add_task.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ text: taskInput.value })
            });
            if (!response.ok) throw new Error("Error al añadir tarea");
            taskInput.value = '';
            await loadTasks();  // Recargar la lista
        } catch (error) {
            console.error("Error:", error);
        }
    });

    // Cargar tareas al inicio
    loadTasks();
});