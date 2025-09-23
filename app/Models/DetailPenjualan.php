<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $table = 'tb_detail_penjualan';
    protected $primaryKey = 'id_detail_penjualan';

    protected $fillable = [
        'id_penjualan',
        'id_obat',
        'jumlah_obat',
        'subtotal_penjualan'
    ];

    public function getSubtotalPenjualanFormattedAttribute()
    {
        return 'Rp ' . number_format($this->subtotal_penjualan, 2, ',', '.');
    }

}
