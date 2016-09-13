<?php

namespace App\Services;
use App\Models\Word;
use App\Models\Answer;
use App\Models\Lesson;
use App\Models\Category;
use Auth;

class HomeService
{
    public static function filterWords($type = self::TYPE_FILTER_WORDS_ALL, $categoryId = null)
    {
        switch ($type) {
            case config('word.filter.new'):
                return self::getNewWordAnswers();
            case config('word.filter.ulearn'):
                return self::getUnlearnedWordAnswers();
            case config('word.filter.learned'):
                return self::getLearnedWordAnswers();
            case config('word.filter.category'):
                return self::getWordAnswersByCategory($categoryId);

            default:
                return self::getAllWordAnswers();
        }
    }

    public static function filterLessons($type = self::TYPE_FILTER_WORDS_ALL, $categoryId = null)
    {
        switch ($type) {
            case config('word.filter.category_lesson'):
                return self::getLessonsByCategory($categoryId);

            default:
                return self::getAllLessons();
        }
    }

    public static function getAllWordAnswers()
    {
        return Word::with('answers')
            ->orderby('content')
            ->paginate(config('paginate.word.normal'), ['*'], 'wordlist_page');
    }

    public static function getAllLessons()
    {
        return Lesson::orderby('created_at', 'desc')->paginate(config('paginate.lesson.normal'));
    }

    public static function getNewWordAnswers()
    {
        return Word::with('answers')
            ->orderby('created_at')
            ->paginate(config('paginate.word.normal'), ['*'], 'wordlist_page');
    }

    public static function getWordAnswersByCategory($categoryId)
    {
        return Word::with('answers')
            ->where('category_id', $categoryId)
            ->paginate(config('paginate.word.normal'), ['*'], 'wordlist_page');
    }

    public static function getLessonsByCategory($categoryId)
    {
        return Lesson::where('category_id', $categoryId)->paginate(config('paginate.word.normal'), ['*'], 'wordlist_page');
    }

    public static function getUnlearnedWordAnswers()
    {
        //Excute later
        return Word::with('answers')
            ->paginate(config('paginate.word.normal'), ['*'], 'wordlist_page');
    }

    public static function getLearnedWordAnswers()
    {
        //Excute later
        return Word::with('answers')
            ->paginate(config('paginate.word.normal'), ['*'], 'wordlist_page');
    }
}
