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
        $dataResult = Result::with('answer', 'answer.word')
            ->where('user_id', $userId)
            ->where('lesson_id', $id)
            ->get();

        if (count($dataResult)) {
            return view('lesson-result', [
                'dataResult' => $dataResult,
                'lesson' => $lesson,
            ]);
        }

        return view('lesson-detail', [
            'lesson' => $lesson,
            'questions' => json_encode($questions),
        ]);
    }
}
