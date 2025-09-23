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
            ['username'=> 'pegawai01','nama' => 'Meisya Aziani', 'role' =>'Pegawai'],
            ['username'=> 'manajer01', 'nama' => 'Aji Santoso', 'role' =>'Manajer']
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
