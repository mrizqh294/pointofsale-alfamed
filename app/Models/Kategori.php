<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'tb_kategori_obat';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'kode',
        'nama',
    ];
}
