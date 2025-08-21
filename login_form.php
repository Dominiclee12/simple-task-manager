<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
</head>

<body>
    <h1>Login</h1>

    <form method="POST" action="login.php">
        <label>Email address</label>
        <input type="email" name="email" placeholder="name@example.com" required /><br>

        <label>Password</label>
        <input type="password" name="password" placeholder="Password" required /><br>

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register_form.php">Register</a></p>
</body>

</html>