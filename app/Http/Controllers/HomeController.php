<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Word;
use App\Models\Category;
use App\Services\HomeService;
use App\Services\DatetimeService;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->input('type') ? $request->input('type') : config('word.filter.all');
        $lessonType = $request->lessonType ? $request->lessonType : config('word.filter.all_lesson');
        $categoryId = $request->category ? $request->category : null;
        $lessons = HomeService::filterLessons($lessonType, $categoryId);
        $filterResults = HomeService::filterWords($type, $categoryId);
        $filterResults->setPageName('wordlist_page');
        $categories = Category::orderby('created_at', 'asc')->pluck('name', 'id');
        $categoryTitle = isset($categories[$categoryId]) ? $categories[$categoryId] : trans('homepage.title_lesson');
        $currentUser = Auth::user();
        $numberFollowers = $currentUser->followers()->count();
        $numberFollowings = $currentUser->followings()->count();
        $numberUnlearnedWords = HomeService::counttUnlearnedWordAnswers($currentUser->id);
        $numberLearnedWords = HomeService::countLearnedWordAnswers($currentUser->id);

        return view('home', [
            'lessons' => $lessons,
            'filterResults' => $filterResults,
            'categories' => $categories,
            'page' => $request->input('page'),
            'type' => $type,
            'categoryTitle' => $categoryTitle,
            'numberFollowers' => $numberFollowers,
            'numberFollowings' => $numberFollowings,
            'numberUnlearnedWords' => $numberUnlearnedWords,
            'numberLearnedWords' => $numberLearnedWords,
        ]);
    }
}
