<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List User</title>

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
.btn-success,
.btn-warning,
.btn-danger {
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

<div class="main-content">

    <div class="d-flex justify-content-between mb-3">
        <h4>List User</h4>
        <span>{{ date('d-m-Y') }}</span>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card p-4">
        <div class="d-flex justify-content-between mb-3">
            <h5>Data User</h5>
            <a href="{{ route('user.create') }}" class="btn btn-success">+ Tambah User</a>
        </div>

        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th width="160">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $u)
                <tr>
                    <td>{{ $u->id_user }}</td>
                    <td>{{ $u->nama }}</td>
                    <td>{{ $u->username }}</td>
                    <td>{{ $u->role->nama ?? '-' }}</td>
                    <td>
                        <a href="{{ route('user.edit', $u->id_user) }}" class="btn btn-warning btn-sm text-white">Edit</a>
                        <form action="{{ route('user.destroy', $u->id_user) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Apakah anda yakin ingin menghapus user ini?')">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

</body>
</html>
