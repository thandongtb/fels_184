<?php

namespace App\Services;
use App\Models\Word;
use App\Models\Answer;
use App\Models\Lesson;
use App\Models\LessonWord;
use App\Models\Category;
use Auth;

class LessonService
{
    public static function getQuestions($lessonId)
    {
        $wordLessons = LessonWord::select('word_id')
            ->where('lesson_id', $lessonId)
            ->get();
        $words = Word::with('answers')
            ->whereIn('id', $wordLessons)
            ->get();
        $questions = [];

        foreach ($words as $key => $word) {
            $question = [];

            $question['question'] = $word->content;

            foreach ($word->answers as $key => $answer) {
                $choice[$key] = $answer->content;
                $wordAnswer[$key] = $answer->id;

                if ($answer->is_correct == config('word.answer.correct')) {
                    $question['correct'] = $answer->content;
                }
            }
            $question['choices'] = $choice;
            $question['answers'] = $wordAnswer;
            array_push($questions, $question);
        }

        return $questions;
    }
}
