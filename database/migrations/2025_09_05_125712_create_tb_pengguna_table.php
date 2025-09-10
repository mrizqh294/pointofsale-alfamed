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
        Schema::create('tb_pengguna', function (Blueprint $table) {
            $table->bigIncrements('id_pengguna');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('nama');
            $table->unsignedBigInteger('id_role');
            $table->timestamps();

            $table->foreign('id_role')->references('id_role')->on('tb_role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pengguna');
    }
};
