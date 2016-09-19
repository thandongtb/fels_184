<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Lesson;
use App\Models\LessonWord;
use App\Models\Word;
use Auth;
use DB;
use App\Http\Requests\UpdateLessonRequest;
use App\Http\Requests\CreateLessonRequest;
use Carbon\Carbon;

class LessonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lessons = Lesson::with('category')->orderby('id')->paginate(config('paginate.lesson.normal'));

        return view('admin.lesson-manager', compact('lessons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all()->pluck('name', 'id');

        return view('admin.lesson-create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLessonRequest $request)
    {
        $lessonData = [
            'name' => $request->lesson_name,
            'category_id' => $request->lesson_category,
        ];

        try {
            DB::beginTransaction();
            $lesson = Lesson::create($lessonData);
            $wordNumber = $request->word_number;
            $words = Word::where('category_id', $request->lesson_category)
                ->inRandomOrder()
                ->limit($wordNumber)
                ->get();
            $lessonWords = [];

            for ($i = 0; $i < $wordNumber; $i++) {
                $lessonWords[] = [
                    'word_id' => $words[$i]->id,
                    'lesson_id' => $lesson->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }

            if ($lessonWords) {
                LessonWord::insert($lessonWords);
            }
            DB::commit();

            return redirect()->action('Admin\LessonsController@index')
                             ->withSuccess(trans('admin/lessons.lesson_create_success'));
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(trans('admin/lessons.lesson_create_fail'));
        }
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

        if ($lesson) {
            $lessonWords = LessonWord::with('word')
                ->where('lesson_id', $id)
                ->get();

            return view('admin.lesson-detail', compact('lesson', 'lessonWords'));
        }

        return redirect()->action('Admin\LessonsController@index')
                         ->withErrors(trans('admin/lessons.error_message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lesson = Lesson::with('category')->find($id);

        if ($lesson) {
            $lessonWords = LessonWord::with('word')->where('lesson_id', $id)->get();
            $words = Lesson::with('category.words')
                ->find($id)
                ->category
                ->words
                ->pluck('content', 'id');

            return view('admin.lesson-update', compact('lesson', 'lessonWords', 'words'));
        }

        return redirect()->action('Admin\LessonsController@index')
                         ->withErrors(trans('admin/lessons.error_message'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLessonRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $lesson = Lesson::find($id);
            $lesson->update([
                'name' => $request->lesson_name
            ]);
            $lessonWords = LessonWord::where('lesson_id', $id)->get();

            foreach ($request['lessonWord'] as $key => $wordId) {
                $lessonWords[$key]->update([
                    'word_id' => $wordId,
                ]);
            }
            DB::commit();

            return redirect()->action('Admin\LessonsController@index')
                             ->withSuccess(trans('admin/lessons.lesson_update_success'));
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(trans('admin/lessons.lesson_update_fail'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            LessonWord::where('lesson_id', $id)->delete();
            Lesson::destroy($id);
            DB::commit();

            return redirect()->action('Admin\LessonsController@index')
                             ->withSuccess(trans('admin/lessons.lesson_delete_success'));
        }
        catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(trans('admin/lessons.lesson_delete_fail'));
        }
    }
}
