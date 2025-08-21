<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Task Manager</title>
    <script src="assets/js/script.js"></script>
</head>

<body>
    <h2>Task Manager</h2>
    <button onclick="logoutUser()">Logout</button><br><br>

    <input type="text" id="title" placeholder="Enter a task" />
    <button onclick="addNewTask()">Add</button>

    <h3>My tasks</h3>
    <table id="taskList"></table>

    <script>
        async function loadTasks() {
            const taskList = document.getElementById("taskList");
            taskList.innerHTML = "";
            const tasks = await getTasks();

            if (tasks.length === 0) {
                taskList.innerHTML = "<p>no task yet</p>"
                return;
            }

            tasks.data.forEach(task => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                        <td>
                            <input type="checkbox"
                                onchange="(el => (async () => { await toggleTask(${task.id}, el.checked); loadTasks(); })())(this)"
                                ${task.status ? "checked" : ""} />
                            <label class="${task.status ? 'text-decoration-line-through text-muted' : ''}">${task.title}</label>
                        </td>
                        <td>
                            <button onclick="(async () => { await deleteTask(${task.id}); loadTasks(); })()">Delete</button>
                        </td>
                    `;
                taskList.appendChild(tr);
            });
        }

        // add new task
        async function addNewTask() {
            const title = document.getElementById("title").value;

            if (!title) {
                alert("title is required");
                return;
            }

            await addTask(title);
            document.getElementById("title").value = "";
            loadTasks();
        }

        // logout
        async function logoutUser() {
            await logout();
            window.location.href = "login_form.php";
        }

        // on initial load for tasks list
        document.addEventListener("DOMContentLoaded", loadTasks);
    </script>
</body>

</html>