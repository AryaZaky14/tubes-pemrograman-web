<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ===== BACKGROUND ===== */
        body {
            background: linear-gradient(135deg, #eef2f7, #f8f9fc);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* ===== LOGIN CARD ===== */
        .login-card {
            width: 100%;
            max-width: 420px;
            border-radius: 18px;
            background: #ffffff;
            border: none;
            padding: 32px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        /* ===== TITLE ===== */
        .login-card h3 {
            color: #212529;
            letter-spacing: 1px;
        }

        /* ===== LABEL ===== */
        .form-label {
            font-weight: 500;
            color: #495057;
        }

        /* ===== INPUT ===== */
        .form-control-lg {
            padding: 14px;
            border-radius: 12px;
            border: 1px solid #ced4da;
        }

        .form-control-lg:focus {
            border-color: #495057;
            box-shadow: 0 0 0 0.15rem rgba(73, 80, 87, 0.25);
        }

        /* ===== BUTTON ===== */
        .btn-primary {
            background: linear-gradient(135deg, #495057, #343a40);
            border-radius: 12px;
            padding: 12px;
            font-size: 17px;
            border: none;
            font-weight: 500;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #343a40, #212529);
        }

        /* ===== ALERT ===== */
        .alert {
            border-radius: 12px;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="login-card shadow-lg">
        <h3 class="text-center mb-4 fw-bold">Login</h3>

        {{-- Alert error --}}
        @if (session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control form-control-lg" name="username" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control form-control-lg" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-100 mt-3">
                Login
            </button>
        </form>
    </div>

</body>

</html>
