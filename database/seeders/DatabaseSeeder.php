<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Stan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Users (Admin, 2 Penjual, Mahasiswa)
        User::updateOrCreate(
            ['email' => 'admin@foodcourt.test'],
            [
                'name' => 'Administrator Foodcourt',
                'role' => 'admin',
                'password' => Hash::make('password123'),
            ]
        );

        $penjual1 = User::updateOrCreate(
            ['email' => 'penjual1@foodcourt.test'],
            [
                'name' => 'Budi Santoso',
                'role' => 'penjual',
                'password' => Hash::make('password123'),
            ]
        );

        $penjual2 = User::updateOrCreate(
            ['email' => 'penjual2@foodcourt.test'],
            [
                'name' => 'Siti Aminah',
                'role' => 'penjual',
                'password' => Hash::make('password123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'mahasiswa@mhs.unesa.ac.id'],
            [
                'name' => 'Mahasiswa Uji Coba',
                'role' => 'mahasiswa',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Seed Stan (Terhubung ke masing-masing Penjual)
        $stanMakanan = Stan::updateOrCreate(
            ['id_pemilik' => $penjual1->id],
            [
                'nama_stan' => 'Stan 01 - Lalapan & Geprek Cak Budi',
            ]
        );

        // 3. Seed Menu (Terhubung ke masing-masing Stan)
        $menus = [
            // Menu Stan 01
            [
                'id_stan' => $stanMakanan->id,
                'nama_menu' => 'Nasi Ayam Geprek Sambal Bawang',
                'harga' => 13000,
                'stok' => 25,
                'kategori' => 'Makanan',
                'foto' => null,
            ],
            [
                'id_stan' => $stanMakanan->id,
                'nama_menu' => 'Nasi Lalapan Lele Goreng',
                'harga' => 12000,
                'stok' => 20,
                'kategori' => 'Makanan',
                'foto' => null,
            ],
            [
                'id_stan' => $stanMakanan->id,
                'nama_menu' => 'Nasi Tahu Tempe Penyet',
                'harga' => 9000,
                'stok' => 30,
                'kategori' => 'Makanan',
                'foto' => null,
            ],
        ];

        foreach ($menus as $menu) {
            Menu::updateOrCreate(
                [
                    'id_stan' => $menu['id_stan'],
                    'nama_menu' => $menu['nama_menu'],
                ],
                $menu
            );
        }
    }
}