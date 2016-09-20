<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Http\Requests;
use App\Models\User;

class ActivitiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function index()
    {
        $activities = Activity::with('user')->paginate(config('paginate.activity.normal'));

        return view('activity-list', compact('activities'));
    }

    public function showFollowingUserActivities($id)
    {
        try {
            $user = User::findOrFail($id);
            $followingUserActivitiess = $user->followings()->with('activities')->paginate(config('paginate.user.normal'));

            return view('activity-follow-list', [
                'user' => $user,
                'title' => trans('homepage.list_activity_foolowing_title'),
                'users' => $followingUserActivitiess,
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function showUserFollowersActivities($id)
    {
        try {
            $user = User::findOrFail($id);
            $followerUserActivitiess = $user->followers()->with('activities')->paginate(config('paginate.user.normal'));

            return view('activity-follow-list', [
                'user' => $user,
                'title' => trans('homepage.list_activity_foolower_title'),
                'users' => $followerUserActivitiess,
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
