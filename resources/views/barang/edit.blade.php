<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Barang</title>
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

/* ===== BUTTON ===== */
.btn-primary {
    background: linear-gradient(135deg, #4b6ef5, #3a5ce0);
    border: none;
    border-radius: 10px;
    padding: 10px 18px;
}

.btn-secondary {
    border-radius: 10px;
    padding: 10px 18px;
}

.btn-danger {
    border-radius: 10px;
}
</style>

</head>

<body>

<div class="sidebar">
    <h3 class="text-center">Admin Jeki</h3>
    <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
    <a href="{{ route('barang.index') }}">📦 Barang</a>
    <a href="{{ route('user.index') }}">👥 User</a>

    <form action="{{ route('logout') }}" method="POST" class="mx-3 mt-3">
        @csrf
        <button class="btn btn-danger w-100">🚪 Logout</button>
    </form>
</div>

<div class="main-content">

    <div class="card p-4">
        <h4>Edit Barang</h4>

        <form method="POST" action="{{ route('barang.update', $barang->id_barang) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama Barang</label>
                <input type="text" name="nama" class="form-control"
                       value="{{ $barang->nama }}" required>
            </div>

            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control"
                       value="{{ $barang->harga }}" required>
            </div>

            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number" name="jumlah" class="form-control"
                       value="{{ $barang->jumlah }}" required>
            </div>

            <button class="btn btn-primary">Perbarui</button>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

</div>

</body>
</html>
