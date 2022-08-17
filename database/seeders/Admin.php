<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class Admin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Ivan Gonzalez',
            'email' => 'kaosolution8@gmail.com',
            'password' => bcrypt(96100709465),
            'role' => 'Administrador'
        ]);
    }
}
