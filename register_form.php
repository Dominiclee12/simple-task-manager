<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
</head>

<body>
    <h1>Register</h1>

    <label>Email address</label>
    <input type="email" id="email" placeholder="name@example.com" /><br>

    <label>Password</label>
    <input type="password" id="password" placeholder="password" /><br>

    <button onclick="register()">Register</button>

    <p>Already have an account? <a href="login_form.php">Login</a></p>

    <script>
        async function register() {
            let email = document.getElementById("email").value;
            let password = document.getElementById("password").value;
            let action = "register";

            let res = await fetch("api/auth.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ action, email, password })
            });
            let data = await res.json();

            console.log("message", data.message);
            alert(data.message);
        }
    </script>
</body>

</html>