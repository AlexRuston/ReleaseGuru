<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // check if Alex exists
        $alexUser = User::where('name', 'Alex Watson')
            ->where('email', 'alex@admin.com')
            ->first();

        // only add him if he doesn't, this would be an issue if we ran seeds multiple times
        if(!$alexUser){
            // create alex user as admin
            User::factory()->create([
                'name' => 'Alex Watson',
                'email' => 'alex@admin.com',
                'password' => Hash::make('password'),
            ]);

            /*
             * give alex Super Admin and Devloper roles
             * */
            foreach([1, 2] as $roleId){
                DB::table('user_role')->insert([
                    'user_id' => 1,
                    'role_id' => $roleId,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        // create 10 users
        User::factory(10)
            ->create();
    }
}
