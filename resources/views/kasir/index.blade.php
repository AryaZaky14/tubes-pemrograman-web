<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        background: linear-gradient(135deg, #eef2f7, #f8f9fc);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* ===== SIDEBAR ===== */
    .sidebar {
        height: 100vh;
        width: 260px;
        position: fixed;
        background: linear-gradient(180deg, #343a40, #212529);
        color: white;
        padding-top: 25px;
        box-shadow: 4px 0 15px rgba(0,0,0,0.15);
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
        transition: all 0.3s ease;
    }

    .sidebar a:hover {
        background: rgba(255,255,255,0.2);
        transform: translateX(5px);
    }

    /* ===== MAIN CONTENT ===== */
    .main-content {
        margin-left: 280px;
        padding: 30px;
    }

    /* ===== CARD ===== */
    .card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }

    /* ===== HEADER ===== */
    .main-content h4 {
        font-weight: bold;
        color: #343a40;
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

    .table td, .table th {
        vertical-align: middle;
    }

    /* ===== BUTTON ===== */
    .btn-primary {
        background: linear-gradient(135deg, #4b6ef5, #3a5ce0);
        border: none;
        border-radius: 10px;
        padding: 10px 16px;
        transition: 0.3s;
    }   

    .btn-primary:hover {
        background: linear-gradient(135deg, #3a5ce0, #2f4fd3);
        transform: translateY(-1px);
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745, #218838);
        border: none;
        border-radius: 10px;
    }

    .btn-danger {
        border-radius: 10px;
    }

    /* ===== INPUT ===== */
    .form-control {
        border-radius: 10px;
        padding: 10px;
    }

    /* ===== ALERT ===== */
    .alert {
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
</style>

</head>
<body>

<div class="sidebar">
    <h3 class="text-center">Kasir Jeki</h3>

    <form action="/logout" method="POST" class="mx-3 mt-3">
        @csrf
        <button class="btn btn-danger w-100">🚪 Logout</button>
    </form>
</div>

<div class="main-content">

    <div class="d-flex justify-content-between mb-3">
        <h4>Kasir</h4>
        <span>{{ date('d-m-Y') }}</span>
    </div>

    <div class="card p-3 mb-4">
        <h5>Hai, {{ auth()->user()->nama }}</h5>
        <small class="text-muted">Silakan lakukan transaksi</small>
    </div>

    @if(session('error') && session('error') != 'kurang')
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error') == 'kurang')
        <div class="alert alert-warning alert-dismissible fade show">
            💰 Uang tidak mencukupi
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        ✅ {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif


    <div class="row">

        <!-- Tambah Barang -->
        <div class="col-md-8">
            <div class="card p-4 mb-4">
                <form method="POST" action="{{ route('kasir.tambah') }}">
                    @csrf
                    <div class="mb-3">
                        <label>Nama Barang</label>
                        <select name="nama_barang" class="form-control" required>
                            <option value="">Pilih Barang</option>
                            @foreach($barang as $b)
                                <option value="{{ $b->nama }}">
                                    {{ $b->nama }}
                                    @if($b->jumlah <= 5)
                                        (Stok : {{ $b->jumlah }})
                                    @endif
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Qty</label>
                        <input type="number" name="qty" class="form-control" required>
                    </div>

                    <button class="btn btn-primary">+ Tambah</button>
                </form>
            </div>

            <!-- Keranjang -->
            <div class="card p-4">
                <form method="POST" action="{{ route('kasir.update') }}">
                    @csrf
                    @if(empty($cart))
                    <div class="alert alert-info text-center">
                        🛒 Keranjang masih kosong
                    </div>
                @endif
                    <table class="table table-bordered text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $c)
                            <tr>
                                <td>{{ $c['nama'] }}</td>
                                <td>Rp {{ number_format($c['harga']) }}</td>
                                <td><input type="number" name="qty[]" min="1" class="form-control" value="{{ $c['qty'] }}"></td>
                                <td>Rp {{ number_format($c['harga'] * $c['qty']) }}</td>
                                <td>
                                    <a href="{{ route('kasir.hapus', $c['id']) }}"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus barang dari keranjang?')">
                                        X
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <button class="btn btn-success">Perbarui Keranjang</button>
                </form>
            </div>
        </div>

        <!-- Total -->
        <div class="col-md-4">
            <div class="card p-4">
                <h4>Total: Rp {{ number_format($sum) }}</h4>
                <hr>

                <form method="POST" action="{{ route('kasir.transaksi') }}">
                    @csrf
                    <input type="hidden" name="total" value="{{ $sum }}">
                    <input type="number" name="bayar" class="form-control mb-3" placeholder="Bayar">
                    <button class="btn btn-primary w-100">Selesaikan</button>
                </form>
            </div>
        </div>

    </div>
</div>

</body>
</html>
