<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>

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
.form-control {
    border-radius: 10px;
}

/* ===== TABLE ===== */
.table {
    border-radius: 12px;
    overflow: hidden;
}

.table thead {
    background: linear-gradient(135deg, #495057, #343a40);
    color: white;
}

.table th,
.table td {
    vertical-align: middle;
}

/* ===== BUTTON ===== */
.btn {
    border-radius: 10px;
}

.btn-warning {
    background-color: #f0ad4e;
    border: none;
}

.btn-warning:hover {
    background-color: #ec971f;
}

/* ===== ALERT ===== */
.alert {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
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

<!-- MAIN -->
<div class="main-content">

    <div class="d-flex justify-content-between mb-3">
        <h4>Edit User</h4>
        <span>{{ date('d-m-Y') }}</span>
    </div>

    <div class="card p-4">

        <h5 class="mb-4">Form Edit User</h5>

        <form action="{{ route('user.update', $user->id_user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control"
                       value="{{ $user->nama }}" required>
            </div>

            <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username"
                class="form-control @error('username') is-invalid @enderror"
                value="{{ old('username', $user->username) }}"
                required>

            @error('username')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
            <div class="mb-3">
                <label class="form-label">Password (Opsional)</label>
                <input type="password" name="password" class="form-control"
                       placeholder="Kosongkan jika tidak diubah">
            </div>

            <div class="mb-3">
                <label class="form-label">Role Akses</label>
                <select name="role_id" class="form-control" required>
                    @foreach ($roles as $r)
                        <option value="{{ $r->id_role }}"
                            {{ $user->role_id == $r->id_role ? 'selected' : '' }}>
                            {{ $r->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    Perbarui
                </button>

                <a href="{{ route('user.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>

        </form>

    </div>
</div>

</body>
</html>
