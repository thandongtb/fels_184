<?php

use Illuminate\Database\Seeder;
use App\Models\Word;
use App\Models\Answer;

class AnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $words = Word::get();

        foreach ($words as $key => $value) {
            for ($i = 0; $i < 4; $i++) {
                if ($i == 1) {
                    Answer::create([
                        'word_id' => $value->id,
                        'content' => $faker->realText($maxNbChars = 255, $indexSize = 2),
                        'is_correct' => true
                    ]);
                }
                Answer::create([
                    'word_id' => $value->id,
                    'content' => $faker->realText($maxNbChars = 255, $indexSize = 2),
                    'is_correct' => false
                ]);
            }
        }
    }
}
