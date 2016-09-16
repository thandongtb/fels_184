<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use App\Http\Requests;

class WordsController extends Controller
{
    public function show($id)
    {
        return view('home');
    }
}
