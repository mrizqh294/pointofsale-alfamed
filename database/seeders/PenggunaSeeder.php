<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penggunas = [
            ['username'=> 'admin01', 'nama' => 'Syakira Jasmine', 'role' =>'Admin'],
            ['username'=> 'pegawai01','nama' => 'Meisya Aziani', 'role' =>'Kasir'],
            ['username'=> 'pemilik', 'nama' => 'Aji Santoso', 'role' =>'Pemilik']
        ];

        $password = '12345678';

        foreach($penggunas as $pengguna)
        {
            Pengguna::create([
                'username' => $pengguna['username'],
                'password' => Hash::make($password),
                'nama' => $pengguna['nama'],
                'role' => $pengguna['role']
            ]);
        }
    }
}
