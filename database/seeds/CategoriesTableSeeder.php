<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            Category::create([
                'name' => $faker->catchPhrase,
                'description' => $faker->realText($maxNbChars = 255, $indexSize = 2)
            ]);
        }
    }
}
