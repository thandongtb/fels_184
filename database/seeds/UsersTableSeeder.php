<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 100; $i++) {
            User::create([
                'email' => $faker->email,
                'name' => $faker->name,
                'password' => bcrypt('123456'),
                'role' => 1
            ]);
        }
        User::create([
            'email' => 'admin@framgia.com',
            'name' => 'Admin',
            'password' => bcrypt('123456'),
            'role' => 2
        ]);
    }
}
