<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Answer;
use App\Http\Requests;
use App\Services\LessonService;
use Auth;
use App\Models\Result;

class LessonsController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lesson = Lesson::find($id);
        $questions = LessonService::getQuestions($id);
        $userId = Auth::user()->id;
        $dataLesson = Result::where('user_id', $userId)
            ->where('lesson_id', $id)
            ->pluck('answer_id');
        $answers = Answer::whereIn('id', $dataLesson)->get();

        if (count($dataLesson)) {
            return view('lesson-result', [
                'answers'=> $answers,
                'lesson'=> $lesson,
            ]);
        }

        return view('lesson-detail', [
            'lesson'=> $lesson,
            'questions' => json_encode($questions),
        ]);
    }
}
