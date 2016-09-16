<?php

namespace App\Services;

use App\Models\LessonWord;

class LessonService
{
    public static function getQuestions($lessonId)
    {
        $lessonWords = LessonWord::with('word', 'word.answers')
            ->where('lesson_id', $lessonId)
            ->get();

        $questions = [];

        foreach ($lessonWords as $key => $lessonWord) {
            $question = [];

            $question['question'] = $lessonWord->word->content;

            foreach ($lessonWord->word->answers as $key => $answer) {
                $choice[$key] = $answer->content;
                $wordAnswer[$key] = $answer->id;

                if ($answer->isCorrect()) {
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
