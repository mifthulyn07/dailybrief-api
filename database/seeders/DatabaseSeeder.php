<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // User::create([
        // 	'id' => '1',
        // 	'nama' => 'Developer',
        //     'email' => 'developer@gmail.com',
        //     'password' => 'developer123',
        //     'role' => 'super-admin',
        // ]);
        
        Absensi::factory()
            ->count(50)
            ->for(User::factory()->state([
                'id' => '1',
        	    'nama' => 'Developer',
                'email' => 'developer@gmail.com',
                'password' => 'developer123',
            ]))
            ->create();
        
        User::factory(50)->create();
        Absensi::factory(50)->create();

    }
}
