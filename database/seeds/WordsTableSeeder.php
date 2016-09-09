<?php

use Illuminate\Database\Seeder;
use App\Models\Word;
use App\Models\Category;

class WordsTableSeeder extends Seeder
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

        for ($i = 0; $i < 1000; $i++) {
            Word::create([
                'content' => $faker->word,
                'category_id' => mt_rand($firstCategoryId, $lastCategoryId)
            ]);
        }
    }
}
