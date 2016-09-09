<?php

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Lesson;

class LessonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $firstCategoryId = Category::orderby('created_at')->first()->id;
        $lastCategoryId = Category::orderby('created_at', 'desc')->first()->id;

        for ($i = 0; $i < 50; $i++) {
            Lesson::create([
                'name' => $faker->sentence($nbWords = 4, $variableNbWords = true),
                'category_id' => mt_rand($firstCategoryId, $lastCategoryId)
            ]);
        }
    }
}
