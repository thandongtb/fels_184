<?php

namespace App\Services;
use App\Models\Word;
use App\Models\Answer;
use Auth;

class HomeService
{
    const TYPE_FILTER_WORDS_NEW = 'new';
    const TYPE_FILTER_WORDS_ALL= 'all';
    const TYPE_FILTER_WORDS_UNLEARN= 'ulearn';
    const TYPE_FILTER_WORDS_LEARNED= 'learned';

    public static function filterWords($type = self::TYPE_FILTER_WORDS_ALL)
    {
        switch ($type) {
            case self::TYPE_FILTER_WORDS_NEW:
                return self::getLearnedWords();
            case self::TYPE_FILTER_WORDS_LEARNED:
                return self::getLearnedWords();
            case self::TYPE_FILTER_WORDS_UNLEARN:
                return self::getUnlearnedWords();

            default:
                return self::getAllWords();
        }
    }

    public static function getAllWords()
    {
        return Answer::where('is_correct', config('word.answer.correct'))->orderby('created_at')->paginate(config('paginate.word.normal'), ['*'], 'wordlist_page');
    }

    public static function getNewWords()
    {
        return Answer::where('is_correct', config('word.answer.correct'))->orderby('created_at', 'desc')->paginate(config('paginate.word.normal'), ['*'], 'wordlist_page');
    }

    public static function getUnlearnedWords()
    {
        //Excute later
        return Answer::where('id', '<', 80)->where('is_correct', config('word.answer.correct'))->orderby('created_at')->paginate(config('paginate.word.normal'), ['*'], 'wordlist_page');
    }

    public static function getLearnedWords()
    {
        //Excute later
        return Answer::where('id', '>', 150)->where('is_correct', config('word.answer.correct'))->orderby('created_at')->paginate(config('paginate.word.normal'), ['*'], 'wordlist_page');
    }
}
