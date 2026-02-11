<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        User::create([
            'name' => 'Aldmic Test',
            'username' => 'aldmic',
            'password' => Hash::make('123abc123'), // Password dienkripsi agar aman
        ]);
    }
}
