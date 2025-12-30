<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    protected $table = 'transaksi_detail';
    protected $primaryKey = 'id_transaksi_detail';
    public $timestamps = false;

    protected $fillable = [
        'id_transaksi','id_barang','harga','qty','total'
    ];
}

