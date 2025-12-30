<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

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

/* ===== HEADER BAR ===== */
.header-bar {
    background: white;
    padding: 15px 25px;
    border-radius: 12px;
    margin-bottom: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
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

.table thead,
.table-danger {
    background: linear-gradient(135deg, #495057, #343a40);
    color: white;
}

.table th,
.table td {
    vertical-align: middle;
}

/* ===== BUTTON ===== */
.btn-primary {
    background: linear-gradient(135deg, #4b6ef5, #3a5ce0);
    border: none;
    border-radius: 10px;
    padding: 10px 16px;
}

.btn-danger {
    border-radius: 10px;
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
    <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
    <a href="{{ route('barang.index') }}">📦 Barang</a>
    <a href="{{ route('user.index') }}">👥 User</a>

    <form action="/logout" method="POST" class="mx-3 mt-3">
        @csrf
        <button class="btn btn-danger w-100">🚪 Logout</button>
    </form>
</div>

<div class="main-content">
    <div class="header-bar">
        <h4>Selamat Datang, {{ auth()->user()->nama }}</h4>
        <span>{{ date('d-m-Y') }}</span>
    </div>

    <div class="card p-4">
        <h4>Dashboard Admin</h4>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card p-3 text-center">
                    <h6>Total Barang</h6>
                    <h3>{{ $barang }}</h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3 text-center">
                    <h6>Total User</h6>
                    <h3>{{ $user }}</h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3 text-center">
                    <h6>Stok Menipis</h6>
                    <h3>{{ $stok_tipis->count() }}</h3>
                </div>
            </div>
        </div>

                <div class="mt-4">
            <h5 class="text-danger">⛔ Barang Stok Habis</h5>

            @if($stok_habis->isEmpty())
                <div class="alert alert-success">
                    ✅ Tidak ada barang yang stoknya habis
                </div>
            @else
                <table class="table table-bordered table-striped">
                    <tr class="table-danger">
                        <th>Nama</th>
                        <th>Stok</th>
                    </tr>
                    @foreach ($stok_habis as $b)
                    <tr>
                        <td>{{ $b->nama }}</td>
                        <td class="text-danger fw-bold">{{ $b->jumlah }}</td>
                    </tr>
                    @endforeach
                </table>
            @endif
        </div>


        <div class="mt-4">
            <h5>⚠ Barang Stok &lt; 5</h5>
            <table class="table table-bordered">
                <tr>
                    <th>Nama</th>
                    <th>Stok</th>
                </tr>
                @foreach ($stok_tipis as $b)
                <tr>
                    <td>{{ $b->nama }}</td>
                    <td>{{ $b->jumlah }}</td>
                </tr>
                @endforeach
            </table>
        </div>

        <div class="mt-4">
            <h5>🧾 5 Transaksi Terakhir</h5>
            <table class="table table-bordered">
                <tr>
                    <th>Nomor</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                </tr>
                @foreach ($transaksi as $t)
                <tr>
                    <td>{{ $t->nomor }}</td>
                    <td>Rp {{ number_format($t->total) }}</td>
                    <td>{{ $t->tanggal_waktu }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

</body>
</html>
