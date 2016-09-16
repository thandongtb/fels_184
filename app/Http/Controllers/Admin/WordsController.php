<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Word;
use App\Models\Answer;
use Auth;
use DB;
use App\Http\Requests\CreateWordRequest;
use App\Http\Requests\UpdateWordRequest;
use Carbon\Carbon;

class WordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $words = Word::with('category')->orderby('id')->paginate(config('paginate.word.normal'));

        return view('admin.word-manager', compact('words'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id');

        return view('admin.word-create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateWordRequest $request)
    {
        $wordData = [
            'content' => $request->word_content,
            'category_id' => $request->category_id,
        ];

        try {
            DB::beginTransaction();
            $word = Word::create($wordData);
            $answers = [];

            foreach ($request['answers']['content'] as $key => $content) {
                $answers[] = [
                    'content' => $content,
                    'is_correct' => $request['answers']['is_correct'][$key],
                    'word_id' => $word->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }

            if ($answers) {
                Answer::insert($answers);
            }
            DB::commit();

            return redirect()->action('Admin\WordsController@index')
                             ->withSuccess(trans('admin/words.word_create_success'));
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(trans('admin/words.word_create_fail'));
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
        $word = Word::find($id);

        if ($word) {
            return view('admin.word-detail', compact('word'));
        }

        return redirect()->action('Admin\WordsController@index')
                         ->withErrors(trans('admin/words.error_message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $word = Word::with('category')->find($id);

        if ($word) {
            $categories = Category::pluck('name');
            $answers = $word->answers;

            return view('admin.word-update', compact('word', 'categories', 'answers'));
        }

        return redirect()->action('Admin\WordsController@index')
                         ->withErrors(trans('admin/words.error_message'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWordRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $word = Word::with('answers')->find($id);
            $word->update([
                'content' => $request->word_content,
                'category_id' => $request->category_id,
            ]);

            foreach ($request['answers']['content'] as $key => $content) {
                $word->answers[$key]->update([
                    'content' => $content,
                    'is_correct' => $request['answers']['is_correct'][$key],
                ]);
            }
            DB::commit();

            return redirect()->action('Admin\WordsController@index')
                             ->withSuccess(trans('admin/words.word_update_success'));
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(trans('admin/words.word_update_fail'));
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
            Answer::where('word_id', $id)->delete();
            Word::destroy($id);
            DB::commit();

            return redirect()->action('Admin\WordsController@index')
                             ->withSuccess(trans('admin/words.word_delete_success'));
        }
        catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(trans('admin/words.word_delete_fail'));
        }
    }
}
