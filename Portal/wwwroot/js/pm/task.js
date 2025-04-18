window.renderTasks = (tasks) => {
    const container = document.getElementById('tasks');
    container.innerHTML = ''; // Clear existing tasks
    const now = new Date();

    tasks.forEach(task => {
        let taskStatus = task.status;
        if (task.status !== 'done' && new Date(task.deadline) < now) {
            taskStatus = 'overdue'; // Mark task as overdue if deadline has passed
        }

        const div = document.createElement('div');
        div.className = `task-card ${taskStatus}`;
        div.innerHTML = `
    <h4>${task.title}</h4>
    <p>${task.description}</p>
    <div class="task-meta">
        <span><strong>Assigned:</strong> ${task.assignedTo}</span>
        <span><strong>Deadline:</strong> ${task.deadline}</span>
        <span><strong>Priority:</strong> ${task.priority}</span>
        <span><strong>Status:</strong> ${taskStatus}</span>
    </div>
    `;
        container.appendChild(div);
    });
}
