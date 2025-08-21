<!DOCTYPE html>
<html lang="en">

<head>
    <title>Simple Task Manager</title>
</head>

<body>
        <h2>Simple Task Manager</h2>
        <a href="logout.php">Logout</a><br><br>

        <input type="text" id="title" placeholder="enter a task" />
        <button onclick="addTask()">Add</button>

        <h3>My tasks</h3>
        <table id="task-list"></table>

    <script>
        // load tasks
        async function loadTasks() {
            let res = await fetch("api.php");
            // json() - decode, stringify() - encode
            let data = await res.json();

            if (!data.success) {
                window.location.assign('login_form.php');
            }

            let list = document.getElementById("task-list");
            list.innerHTML = "";
            data.tasks.forEach(task => {
                let tr = document.createElement("tr");
                tr.innerHTML = `
                        <td>
                            <input type="checkbox"
                                onchange="toggleTask(${task.id}, this.checked)"
                                ${task.status ? "checked" : ""} />
                            <label class="${task.status ? 'text-decoration-line-through text-muted' : ''}">${task.title}</label>
                        </td>
                        <td>
                            <button onclick="deleteTask(${task.id})">Delete</button>
                        </td>
                    `;
                list.appendChild(tr);
            });
        }

        // add task
        async function addTask() {
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
        async function toggleTask(id, status) {
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
        async function deleteTask(id) {
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