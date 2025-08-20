<!DOCTYPE html>
<html lang="en">

<head>
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <title>Register</title>
</head>

<body>
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-sm-4 text-center">
                <h1 class="mb-3">Register</h1>

                <form method="POST" action="register.php">
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control" placeholder="name@example.com" required />
                        <label>Email address</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required />
                        <label>Password</label>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>

                <p class="text-muted">Already have an account? <a href="login_form.php">Login</a></p>
            </div>
        </div>
    </div>

    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>