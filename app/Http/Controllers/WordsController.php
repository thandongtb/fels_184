<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use App\Http\Requests;

class WordsController extends Controller
{
    public function show($id)
    {
        $word = Word::find($id);

        if ($word) {
            return view('word-detail', compact('word'));
        }

        return redirect()->action('HomeController@index')
                         ->withErrors(trans('admin/words.error_message'));
    }
}
