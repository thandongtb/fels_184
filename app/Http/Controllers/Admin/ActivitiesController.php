<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Http\Requests;
use App\Models\User;

class ActivitiesController extends Controller
{
    public function index()
    {
        $activities = Activity::with('user')->paginate(config('paginate.activity.normal'));

        return view('admin.activities-manager', compact('activities'));
    }

    public function show($id)
    {
        $user = User::find($id);
        $activities = Activity::where('user_id', $id)->paginate(config('paginate.activity.normal'));

        return view('admin.user-activities', compact('activities', 'user'));
    }
}
