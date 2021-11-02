<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \DB::table('users')->insert([
            [
                'name' => 'axel',
                'email' => 'p@gmail.com',
                'password' => \Hash::make('admin'),
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1945-08-17',
                'role' => 'Admin',
                'active' => '1'
            ],
            [
                'name' => 'yere',
                'email' => 'yere@gmail.com',
                'password' => \Hash::make('user'),
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1945-10-28',
                'role' => 'User',
                'active' => '1'
            ]
        ]);

        \DB::table('mejas')->insert([
            [
                'nama' => 'Meja 1',
                'status' => 0
            ],
            [
                'nama' => 'Meja 2',
                'status' => 0
            ],
            [
                'nama' => 'Meja 3',
                'status' => 0
            ],
            [
                'nama' => 'Meja 4',
                'status' => 0
            ],
            [
                'nama' => 'Meja 5',
                'status' => 0
            ],

        ]);

        \DB::table('menus')->insert([
            [
                'nama' => 'Nasi Putih',
                'status' => 1,
                'harga' => 5000,
                'kategori' => 'Makanan'
            ],

            [
                'nama' => 'Nasi Goreng',
                'status' => 1,
                'harga' => 10000,
                'kategori' => 'Makanan'
            ],

            [
                'nama' => 'Ayam Geprek',
                'status' => 1,
                'harga' => 10000,
                'kategori' => 'Makanan'
            ],

            [
                'nama' => 'Aqua Gelas',
                'status' => 1,
                'harga' => 5000,
                'kategori' => 'Minuman'
            ],

            [
                'nama' => 'Es Jeruk',
                'status' => 1,
                'harga' => 12000,
                'kategori' => 'Minuman'
            ],

        ]);

        \DB::table('pakets')->insert([
            [
                'nama' => 'Paket 1',
                'status' => 1,
                'harga' => 15000,
            ],
            [
                'nama' => 'Paket 2',
                'status' => 1,
                'harga' => 20000,
            ],
        ]);

        \DB::table('menu_paket')->insert([
            [
                'paket_id' => 1,
                'menu_id' => 1,
            ],
            [
                'paket_id' => 1,
                'menu_id' => 3,
            ],
            [
                'paket_id' => 1,
                'menu_id' => 4,
            ],
            [
                'paket_id' => 2,
                'menu_id' => 2,
            ],
            [
                'paket_id' => 2,
                'menu_id' => 5,
            ],
        ]);
    }
}
