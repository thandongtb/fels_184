<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LessonWord;
use App\Models\Result;
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

            foreach ($results as $key => $value) {
                $data[] = [
                    'user_id' => $userId,
                    'answer_id' => $value,
                    'lesson_id' => $lessonId,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            Result::insert($data);
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
