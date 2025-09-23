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
        Schema::create('tb_penjualan', function (Blueprint $table) {
            $table->bigIncrements('id_penjualan');
            $table->decimal('total_penjualan', 15, 2);
            $table->date('tgl_penjualan');
            $table->unsignedBigInteger('id_pengguna');
            $table->timestamps();

            $table->foreign('id_pengguna')->references('id_pengguna')->on('tb_pengguna');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_penjualan');
    }
};
