<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'tb_pembelian';
    protected $primaryKey = 'id_pembelian';

    protected $fillable = [
        'id_supplier',
        'id_pengguna',
        'tota_pembelian'
    ];
}
