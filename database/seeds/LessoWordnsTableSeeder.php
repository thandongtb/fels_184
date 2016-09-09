<?php

use Illuminate\Database\Seeder;
use App\Models\Word;
use App\Models\Lesson;
use App\Models\LessonWord;

class LessoWordnsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $firstWordId = Word::orderby('created_at')->first()->id;
        $lastWordId = Word::orderby('created_at', 'desc')->first()->id;
        $lessons = Lesson::get();

        foreach ($lessons as $key => $value) {
            for ($i = 0; $i < 10; $i++) {
                LessonWord::create([
                    'lesson_id' => $value->id,
                    'word_id' => mt_rand($firstWordId, $lastWordId)
                ]);
            }
        }
    }
}
