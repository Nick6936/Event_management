<!Doctype htmm>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=devide-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Conpatible" content="ie=edge">
    <title>Add User Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .centered-container {
            min-height: 100vh;
        }
    </style>

</head>

<body>
    <div class="container d-flex justify-content-center align-items-center centered-container"">
        <div class="row justify-content-center">
            <div class = "col-12 col-md-18 col-lg-14">
                <h1>Register</h1>
                <form action="{{ route('registerSave') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" value="{{ old('name') }}" class="form-control" name="name">
                        <span class="text-danger">
                            @error('name')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" value="{{ old('email') }}" class="form-control" name="email">
                        <span class="text-danger">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" value="{{ old('password') }}" class="form-control" name="password">
                        <span class="text-danger">
                            @error('password')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
