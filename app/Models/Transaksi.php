<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    public $timestamps = false;

    protected $fillable = [
        'nomor','nama','total','bayar','kembali','tanggal_waktu'
    ];

    public function detail()
    {
        return $this->hasMany(TransaksiDetail::class, 'id_transaksi');
    }
}
