// login
async function login(email, password) {
    const res = await fetch("api/auth.php", {
        method: "POST",
        headers: "application/json",
        body: { action: "login", email, password }
    });
    return res.json();
}

// register
async function register(email, password) {
    const res = await fetch("api/auth.php", {
        method: "POST",
        headers: "application/json",
        body: { action: "register", email, password }
    });
    return res.json();
}

// logout
async function logout() {
    const res = await fetch("api/auth.php", { method: "GET" });
    return res.json();
}

// get tasks
async function getTasks() {
    const res = await fetch("api/tasks.php", { method: "GET" });
    return res.json();
}

// add task
async function addTask(title) {
    const res = await fetch("api/tasks.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ title })
    });
    return res.json();
}

// toggle task's status
async function toggleTask(id, status) {
    const res = await fetch("api/tasks.php", {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id, status })
    });
    return res.json();
}

// delete task
async function deleteTask(id) {
    const res = await fetch("api/tasks.php", {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id })
    });
    return res.json();
}