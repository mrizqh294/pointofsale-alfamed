<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'tb_pembelian';
    protected $primaryKey = 'id_pembelian';

    protected $fillable = [
        'id_supplier',
        'id_pengguna',
        'total_pembelian',
        'tgl_pembelian'
    ];

    public function getTotalPembelianFormattedAttribute()
    {
        return 'Rp ' . number_format($this->total_pembelian, 2, ',', '.');
    }

    public function getTglPembelianFormattedAttribute()
    {
        return $this->tgl_pembelian 
            ? Carbon::parse($this->tgl_pembelian)->translatedFormat('d F Y')
            : null;
    }
}

