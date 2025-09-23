<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table = 'tb_obat';
    protected $primaryKey = 'id_obat';

    protected $fillable = [
        'nama',
        'id_kategori',
        'harga_jual',
        'harga_beli',
        'role',
        'stok'
    ];

    public function getHargaJualFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga_jual, 2, ',', '.');
    }

    public function getHargaBeliFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga_beli, 2, ',', '.');
    }
}
