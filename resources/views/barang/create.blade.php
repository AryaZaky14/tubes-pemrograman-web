<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tambah Barang</title>

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
            box-shadow: 4px 0 12px rgba(0, 0, 0, 0.15);
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
            background: rgba(255, 255, 255, 0.08);
            text-decoration: none;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.25);
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
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }

        /* ===== FORM ===== */
        .form-label {
            font-weight: 500;
        }

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
        <a href="/dashboard">🏠 Dashboard</a>
        <a href="/barang">📦 Barang</a>
        <a href="/user">👥 User</a>

        <form action="/logout" method="POST" class="mx-3 mt-3">
            @csrf
            <button class="btn btn-danger w-100">🚪 Logout</button>
        </form>
    </div>

    <div class="main-content">

        <div class="d-flex justify-content-between mb-3">
            <h4>Tambah Barang</h4>
            <span>{{ date('d-m-Y') }}</span>
        </div>

        <div class="card p-4">

            <h5 class="mb-4">Form Tambah Barang</h5>

            <form action="{{ route('barang.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah Stok</label>
                    <input type="number" name="jumlah" class="form-control" required>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button class="btn btn-primary">Simpan</button>
                    <a href="/barang" class="btn btn-secondary">Kembali</a>
                </div>

            </form>

        </div>
    </div>

</body>

</html>
