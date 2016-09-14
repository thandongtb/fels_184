<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LessonWord;
use App\Models\Result;
use App\Http\Requests;
use Response;
use Auth;
use DB;

class ResultController extends Controller
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
        $result = explode(',', $request->result);
        $lessonId = $request->lesson_id;
        $userId = Auth::user()->id;

        DB::beginTransaction();
        try {
            $datas = [];

            foreach ($result as $key => $value) {
                $data['user_id'] = $userId;
                $data['answer_id'] = $value;
                $data['lesson_id'] = $lessonId;
                array_push($datas, $data);
            }
            Result::insert($datas);
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
