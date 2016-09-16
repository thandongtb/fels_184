<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LessonWord;
use App\Models\Result;
use App\Models\Answer;
use App\Models\Activity;
use App\Http\Requests;
use Carbon\Carbon;
use Response;
use Auth;
use DB;

class ResultsController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $results = explode(',', $request->result);
        $lessonId = $request->lesson_id;
        $userId = Auth::user()->id;

        DB::beginTransaction();
        try {
            $data = [];
            $activity = [];

            foreach ($results as $key => $value) {
                $data[] = [
                    'user_id' => $userId,
                    'answer_id' => $value,
                    'lesson_id' => $lessonId,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];

                try {
                    $answer = Answer::findOrFail($value);

                    if ($answer->is_correct) {
                        $activity[] = [
                            'user_id' => $userId,
                            'target_id' => config('activity.target_id.new_word'),
                            'object_id' => Answer::with('word')->find($value)->word->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }
                } catch (ModelNotFoundException $ex) {
                    return redirect()->back()->withErrors($ex->getMessage());
                }
            }

            Result::insert($data);
            Activity::create([
                'user_id' => $userId,
                'target_id' => config('activity.target_id.new_lesson'),
                'object_id' => $lessonId,
            ]);
            Activity::insert($activity);

            DB::commit();

            return Response::json([
                'success' => true,
                'message' => trans('lesson.message.save-success'),
            ]);
        } catch (Exception $e) {
            DB::rollback();

            return Response::json([
                'success' => false,
                'message' => trans('lesson.message.save-failed'),
            ]);
        }
    }
}
