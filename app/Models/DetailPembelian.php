<?php

namespace App\Models;

use Carbon\Carbon;
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
        'tgl_kadaluarsa',
        'subtotal_pembelian'
    ];

    public function getSubtotalPembelianFormattedAttribute()
    {
        return 'Rp ' . number_format($this->subtotal_pembelian, 2, ',', '.');
    }

    public function getHargaBeliFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga_beli, 2, ',', '.');
    }

    public function getTglKadaluarsaFormattedAttribute()
    {
        return $this->tgl_kadaluarsa 
            ? Carbon::parse($this->tgl_kadaluarsa)->translatedFormat('d F Y')
            : null;
    }
}
