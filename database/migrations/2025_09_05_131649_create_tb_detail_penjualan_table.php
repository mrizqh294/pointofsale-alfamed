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
        Schema::create('tb_detail_penjualan', function (Blueprint $table) {
            $table->bigIncrements('id_detail_penjualan');
            $table->unsignedBigInteger('id_penjualan');
            $table->unsignedBigInteger('id_obat');
            $table->integer('jumlah_obat');
            $table->decimal('sub_total_transaksi');
            $table->timestamps();

            $table->foreign('id_penjualan')->references('id_penjualan')->on('tb_penjualan');
            $table->foreign('id_obat')->references('id_obat')->on('tb_obat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_detail_penjualan');
    }
};
