<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Auth;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\CreateUserRequest;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderby('name')->paginate(config('paginate.user.normal'));

        return view('admin.user-manager', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $configPath = config('common.user.path');

        if ($request->hasFile('avatar')) {
            $avatar = $request->avatar;
            $fileName = uniqid() . '-' . $avatar->getClientOriginalName();
            $avatar->move(public_path() . $configPath['avatar_url'], $fileName);
        } else {
            $fileName = $configPath['default_name_avatar'];
        }

        $input = $request->only('name', 'email', 'role');
        $input['avatar'] = $fileName;
        $input['password'] = bcrypt($request->password);

        if (User::create($input)) {
            return redirect()->action('Admin\UsersController@index')
                             ->withSuccess(trans('admin/users.user_create_success'));
        }

        return redirect()->action('Admin\UsersController@show')
                         ->withErrors(trans('admin/users.user_create_errors'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('activities')->find($id);

        if ($user) {
            return view('admin.user-profile', compact('user'));
        }

        return redirect()->action('Admin\UsersController@index')
                         ->withErrors(trans('admin/users.error_message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        if ($user) {
            return view('admin.user-update', compact('user'));
        }

        return redirect()->action('Admin\UsersController@index')
                         ->withErrors(trans('admin/users.error_message'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);
        $config = config('common.user.path');

        if ($request->hasFile('avatar')) {
            $avatar = $request->avatar;
            $fileName = uniqid() . '-' . $avatar->getClientOriginalName();
            $avatar->move(public_path() . $config['avatar_url'], $fileName);
        } else {
            $fileName = $config['default_name_avatar'];
        }

        if ($user) {
            $result = $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => bcrypt($request->password),
                'avatar' => $fileName,
            ]);

            if ($result) {
                return redirect()->action('Admin\UsersController@show', compact('user'))
                                 ->withSuccess(trans('admin/users.user_update_success'));
            }

            return redirect()->action('Admin\UsersController@show', compact('user'))
                             ->withErrors(trans('admin/users.user_update_errors'));
        }

        return redirect()->action('Admin\UsersController@index')
                         ->withErrors(trans('admin/users.error_message'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if ($user) {
            if ($user->delete()) {
                return redirect()->action('Admin\UsersController@index')
                                 ->withSuccess(trans('admin/users.user_delete_success'));
            }

            return redirect()->back()->withErrors(trans('admin/users.user_delete_fail'));
        }

        return redirect()->action('Admin\UsersController@index')
                         ->withErrors(trans('admin/users.error_message'));
    }

    public function showFollowingUser($id)
    {
        try {
            $user = User::find($id);
            $followingUsers = $user->followings()->paginate(config('paginate.user.normal'));

            return view('admin.user-following', [
                'user' => $user,
                'title' => trans('admin/users.list_user_foolowing_title'),
                'users' => $followingUsers,
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function showUserFollowers($id)
    {
        try {
            $user = User::find($id);
            $followerUsers = $user->followers()->paginate(config('paginate.user.normal'));

            return view('admin.user-follower', [
                'user' => $user,
                'title' => trans('admin/users.list_user_foolower_title'),
                'users' => $followerUsers,
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
