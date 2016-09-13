<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Word;
use App\Models\Category;
use App\Services\HomeService;
use App\Services\DatetimeService;

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
        $words = HomeService::filterWords($type, $categoryId);
        $words->setPageName('wordlist_page');
        $categories = Category::orderby('created_at', 'asc')->pluck('name', 'id');
        $categoryTitle = isset($categories[$categoryId]) ? $categories[$categoryId] : trans('homepage.title_lesson');

        return view('home', [
            'lessons' => $lessons,
            'words' => $words,
            'categories' => $categories,
            'page' => $request->input('page'),
            'type' => $type,
            'categoryTitle' => $categoryTitle,
        ]);
    }
}
