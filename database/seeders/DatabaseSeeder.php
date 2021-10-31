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
    }
}
