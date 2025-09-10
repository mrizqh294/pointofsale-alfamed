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
        Schema::create('tb_pembelian', function (Blueprint $table) {
            $table->bigIncrements('id_pembelian');
            $table->unsignedBigInteger('id_pengguna');
            $table->unsignedBigInteger('id_supplier');
            $table->decimal('total_pembelian');
            $table->dateTime('tgl_pembelian', precision:0);
            $table->timestamps();

            $table->foreign('id_pengguna')->references('id_pengguna')->on('tb_pengguna');
            $table->foreign('id_supplier')->references('id_supplier')->on('tb_supplier');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pembelian');
    }
};
