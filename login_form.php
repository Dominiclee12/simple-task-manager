<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
</head>

<body>
    <h1>Login</h1>

    <label>Email address</label>
    <input type="email" id="email" placeholder="name@example.com" /><br>

    <label>Password</label>
    <input type="password" id="password" placeholder="password" /><br>

    <button onclick="login()">Login</button>

    <p>Don't have an account? <a href="register_form.php">Register</a></p>

    <script>
        async function login() {
            let email = document.getElementById("email").value;
            let password = document.getElementById("password").value;

            let res = await fetch("api/auth.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ email, password })
            });
            if (res.ok) {
                let data = await res.json();
                if (data.success) {
                    window.location.assign('index.php');
                }
    
                console.log("message", data.message);
            }
        }
    </script>
</body>

</html>