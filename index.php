<!DOCTYPE html>
<html lang="en">

<head>
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <title>Simple Task Manager</title>
</head>

<body>
    <div class="container">
        <h2>Simple Task Manager (API)</h2>
        <a href="logout.php">Logout</a>

        <h3>Add new task</h3>
        <input type="text" id="title" placeholder="study php" required />
        <button type="button" onclick="AddTask()">Add</button>

        <h3>My tasks</h3>
        <ul id="task-list"></ul>
    </div>

    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // load tasks
        async function loadTasks() {
            let res = await fetch("api.php");
            // json() - decode, stringify() - encode
            let data = await res.json();

            if (data.success) {
                let list = document.getElementById("task-list");
                list.innerHTML = "";
                data.tasks.forEach(task => {
                    let li = document.createElement("li");
                    li.innerHTML = `
                        <b>${task.title}</b> |
                        ${task.status} |
                        <button onclick="UpdateTask(${task.id}, 'done')">done</button> |
                        <button onclick="DeleteTask(${task.id})">delete</button>
                    `;
                    list.appendChild(li);
                });
            }
        }

        // add task
        async function AddTask() {
            let title = document.getElementById("title").value;

            let res = await fetch("api.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    title
                })
            })
            let data = await res.json();

            if (data.success) {
                document.getElementById("title").value = "";
            }

            alert(data.message);
            loadTasks();
        }

        // update task
        async function UpdateTask(id, status) {
            let res = await fetch("api.php", {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    id,
                    status
                })
            });
            let data = await res.json();
            alert(data.message);
            loadTasks();
        }

        // delete task
        async function DeleteTask(id) {
            let res = await fetch("api.php", {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    id
                })
            });
            let data = await res.json();
            alert(data.message);
            loadTasks();
        }

        // on initial load for tasks list
        loadTasks();
    </script>
</body>

</html>