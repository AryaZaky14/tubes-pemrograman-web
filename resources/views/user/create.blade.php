<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah User</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
/* ===== GLOBAL ===== */
body {
    background: linear-gradient(135deg, #eef2f7, #f8f9fc);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* ===== SIDEBAR ===== */
.sidebar {
    height: 100vh;
    width: 250px;
    position: fixed;
    background: linear-gradient(180deg, #343a40, #212529);
    color: white;
    padding-top: 25px;
    box-shadow: 4px 0 12px rgba(0,0,0,0.15);
}

.sidebar h3 {
    font-weight: bold;
    letter-spacing: 1px;
    margin-bottom: 30px;
}

.sidebar a {
    display: block;
    padding: 14px 20px;
    margin: 10px 15px;
    border-radius: 10px;
    color: white;
    background: rgba(255,255,255,0.08);
    text-decoration: none;
}

.sidebar a:hover {
    background: rgba(255,255,255,0.25);
}

/* ===== MAIN CONTENT ===== */
.main-content {
    margin-left: 260px;
    padding: 25px;
}

/* ===== HEADER ===== */
.main-content h4 {
    font-weight: 600;
}

/* ===== CARD ===== */
.card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
}

/* ===== FORM ===== */
.form-control,
.form-select {
    border-radius: 10px;
}

/* ===== BUTTON ===== */
.btn {
    border-radius: 10px;
}

/* ===== ALERT / VALIDATION ===== */
.alert,
.invalid-feedback {
    border-radius: 12px;
}

    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h3 class="text-center">Admin Jeki</h3>
    <a href="/dashboard">🏠 Dashboard</a>
    <a href="/barang">📦 Barang</a>
    <a href="{{ route('user.index') }}">👥 User</a>

    <form action="/logout" method="POST" class="mx-3 mt-3">
        @csrf
        <button class="btn btn-danger w-100">🚪 Logout</button>
    </form>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">

    <div class="d-flex justify-content-between mb-3">
        <h4>Tambah User</h4>
        <span>{{ date('d-m-Y') }}</span>
    </div>

    <div class="card p-4">

        <h5 class="mb-4">Form Tambah User</h5>

<form method="POST" action="{{ route('user.store') }}">
    @csrf

    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" required>
    </div>

    <div class="mb-3">
    <label>Username</label>
    <input type="text" name="username"
           class="form-control @error('username') is-invalid @enderror"
           value="{{ old('username') }}"
           required>

    @error('username')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Role Akses</label>
        <select name="role_id" class="form-control" required>
            <option value="">-- Pilih Role --</option>

            @foreach ($roles as $r)
                <option value="{{ $r->id_role }}">
                    {{ $r->nama }}
                </option>
            @endforeach

        </select>
    </div>

    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('user.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
</form>


    </div>
</div>

</body>
</html>
