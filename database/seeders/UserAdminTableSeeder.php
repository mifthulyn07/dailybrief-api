<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserAdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::truncate();
        User::create([
            'id' => '1',
        	'nama' => 'Developer',
            'email' => 'developer@gmail.com',
            'password' => bcrypt('developer123'),
        ]);
    }
}
