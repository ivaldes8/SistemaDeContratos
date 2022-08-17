<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = 'Administrador';
        $role->description = 'Puede acceder a todo';
        $role->save();
        $role = new Role();
        $role->name = 'Especialista';
        $role->description = 'Puede acceder a todo menos a los usuarios';
        $role->save();
        $role = new Role();
        $role->name = 'Usuario';
        $role->description = 'Solo puede ver informacion y realizar consultas';
        $role->save();
    }
}
