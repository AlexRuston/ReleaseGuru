<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
         * we'll use the key of this array as the hierarchy value
         * this is used later against our policies to restrict access to modules / routes etc
         * */
        foreach(['Super Admin', 'Admin', 'Developer'] as $hierarchy => $role){
            Role::create([
                'name' => $role,
                'hierarchy' => $hierarchy,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
