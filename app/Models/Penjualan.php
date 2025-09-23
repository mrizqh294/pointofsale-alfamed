<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'tb_penjualan';
    protected $primaryKey = 'id_penjualan';

    protected $fillable = [
        'total_penjualan',
        'id_pengguna',
        'tgl_penjualan'
    ];

    public function getTotalPenjualanFormattedAttribute()
    {
        return 'Rp ' . number_format($this->total_penjualan, 2, ',', '.');
    }

    public function getTglPenjualanFormattedAttribute()
    {
        return $this->tgl_penjualan 
            ? Carbon::parse($this->tgl_penjualan)->translatedFormat('d F Y')
            : null;
    }
}
