<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Word;
use App\Models\Answer;
use Auth;
use DB;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
