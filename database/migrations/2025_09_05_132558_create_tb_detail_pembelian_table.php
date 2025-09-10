<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_detail_pembelian', function (Blueprint $table) {
            $table->bigIncrements('id_detail_pembelian');
            $table->unsignedBigInteger('id_pembelian');
            $table->unsignedBigInteger('id_obat');
            $table->decimal('harga_beli');
            $table->integer('jumlah_obat');
            $table->date('tgl_kadaluarsa');
            $table->timestamps();

            $table->foreign('id_pembelian')->references('id_pembelian')->on('tb_pembelian');
            $table->foreign('id_obat')->references('id_obat')->on('tb_obat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_detail_pembelian');
    }
};
