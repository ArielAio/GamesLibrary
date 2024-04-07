<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name_user' => 'Exemplo',
            'email_user' => 'exemplo@example.com',
            'password_user' => bcrypt('senha123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
