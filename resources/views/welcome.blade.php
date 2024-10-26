<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Event Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5 text-center">
        <h1 class="mb-4">Event Management System</h1>
        <div class="mb-4">
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-2">Register</a>
            <a href="{{ route('login') }}" class="btn btn-secondary btn-lg">Login</a>
        </div>
        <div class="mt-5">
            <h5>Created by: Nikhil Parajuli</h5>
            <p>Email: <a href="mailto:nikhilparajuli31@gmail.com">nikhilparajuli31@gmail.com</a></p>
            <h6>Login Credentials(Seeding Required!!):</h6>
            <p>Email: <strong>admin@admin.com</strong></p>
            <p>Password: <strong>password123</strong></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
