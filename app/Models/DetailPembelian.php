<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    protected $table = 'tb_detail_pembelian';
    protected $primaryKey = 'id_detail_pembelian';

    protected $fillable = [
        'id_pembelian',
        'id_obat',
        'jumlah_obat',
        'harga_beli',
        'tgl_kadaluarsa'
    ];
}
