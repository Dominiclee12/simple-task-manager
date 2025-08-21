<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
</head>

<body>
    <h1>Register</h1>

    <form method="POST" action="register.php">
        <label>Email address</label>
        <input type="email" name="email" placeholder="name@example.com" required /><br>

        <label>Password</label>
        <input type="password" name="password" placeholder="Password" required /><br>

        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login_form.php">Login</a></p>
</body>

</html>