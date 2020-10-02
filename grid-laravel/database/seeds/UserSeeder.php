<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::table('users')->insert([
            'name' => 'sekva',
            'email' => 'sekva@sekva.com',
            'password' => Hash::make('asdasdasd'),
            'admin' => true,
            'api_token' => Str::random(80),
        ]);

        DB::table('users')->insert([
            'name' => 'baltz',
            'email' => 'baltz@baltz.com',
            'password' => Hash::make('asdasdasd'),
            'admin' => true,
            'api_token' => Str::random(80),
        ]);

        for($i = 0; $i < 5; $i++) {
            DB::table('users')->insert([
                'name' => Str::random(10),
                'email' => Str::random(10).'@gmail.com',
                'password' => Hash::make('asdasdasd'),
                'admin' => false,
                'api_token' => Str::random(80),
            ]);
        }

    }
}
