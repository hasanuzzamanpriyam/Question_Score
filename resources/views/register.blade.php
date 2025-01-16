<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('users.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="user_name" class="form-label">User Name</label>
                                <input type="text" class="form-control" id="user_name" name="username" required>
                            </div>

                            <div class="mb-3">
                                <label for="user_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="user_email" name="user_email" required>
                            </div>

                            <div class="mb-3">
                                <label for="user_number" class="form-label">Number</label>
                                <input type="number" class="form-control" id="user_number" name="user_number" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Register</button>
                            <a href="{{ url('/') }}" class="btn btn-primary">Login</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
