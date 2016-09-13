<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Word;
use App\Models\Category;
use App\Services\HomeService;

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
        $type = $request->input('type') ? $request->input('type') : 'all';
        $lessons = Lesson::orderby('created_at', 'desc')->paginate(config('paginate.lesson.normal'));
        $words = HomeService::filterWords($type);
        $words->setPageName('wordlist_page');
        $categories = Category::orderby('created_at', 'asc')->paginate(config('paginate.category.normal'));

        return view('home', [
            'lessons' => $lessons,
            'words' => $words,
            'categories' => $categories,
            'page' => $request->input('page'),
            'type' => $type,
        ]);
    }
}
