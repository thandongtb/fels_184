<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Http\Requests;
use Validator;
use Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'avatar' => 'mimes:jpeg,jpg,png|max:1000',
        ]);
    }

    protected function validatorPassword(array $data)
    {
        return Validator::make($data, [
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderby('name')->paginate(config('paginate.user.normal'));

        return view('user-list', compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);

            return view('user-profile', compact('user'));
        } catch (ModelNotFoundException $ex) {
            return view('user-profile')->withErrors($ex->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->isCurrent()) {
                return view('user-update', compact('user'));
            }

            return redirect()->to(action('HomeController@index'));
        } catch (ModelNotFoundException $ex) {
            return view('user-profile')->withErrors($ex->getMessage());
        }
    }

    public function showFollowingUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $followingUsers = $user->followings()->paginate(config('paginate.user.normal'));

            return view('user-list', [
                'user' => $user,
                'title' => trans('homepage.list_user_foolowing_title'),
                'users' => $followingUsers,
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function showUserFollowers($id)
    {
        try {
            $user = User::findOrFail($id);
            $followerUsers = $user->followers()->paginate(config('paginate.user.normal'));

            return view('user-list', [
                'user' => $user,
                'title' => trans('homepage.list_user_foolower_title'),
                'users' => $followerUsers,
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
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
        if ($request->hasFile('avatar')) {
            $data = $request->only('name', 'email', 'avatar');
        } else {
            $data = $request->only('name', 'email');
        }

        $validator = $this->validator($data);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->all());
        }

        $configPath = config('common.user.path');

        if (isset($data['avatar'])) {
            $avatar = $request->file('avatar');
            $fileName = uniqid() . '-' . $avatar->getClientOriginalName();
            $request->file('avatar')->move(base_path() . $configPath['public_avatar_url'], $fileName);
            $data['avatar'] = $fileName;
        }

        try {
            $result = User::findOrFail($id)->update($data);

            if ($result) {
                return redirect()->to(action('UsersController@show', ['id' => $id]));
            }
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function getResetPasswordForm($userId)
    {
        try {
            $user = User::findOrFail($userId);

            if ($user->isCurrent()) {
                return view('change-password', compact('user'));
            }

            return redirect()->to(action('HomeController@index'));
        } catch (ModelNotFoundException $ex) {
            return view('user-profile')->withErrors($ex->getMessage());
        }
    }

    public function resetPasssword(Request $request)
    {
        $data = $request->only('old_password', 'password', 'password_confirmation');

        try {
            $user = User::findOrFail($request->id);
            $checkOldPassword = $user->isNullPassword() || Hash::check($data['old_password'], $user->password);

            if ($checkOldPassword) {
                $validator = $this->validatorPassword($data);

                if ($validator->fails()) {
                    return redirect()->to(action('UsersController@show', ['id' => $request->id]))
                        ->withErrors($validator);
                }

                $result = $user->update(['password' => $data['password']]);

                if ($result) {
                    return redirect()->to(action('UsersController@show', ['id' => $request->id]))->with([
                        'success' => trans('admin/users.change_password_success')
                    ]);
                }

                return redirect()->to(action('UsersController@show', ['id' => $request->id]))->with([
                    'message' => trans('admin/users.change_password_error')
                ]);
            }

            return redirect()->to(action('UsersController@show', ['id' => $request->id]))->with([
                'message' => trans('admin/users.change_password_error_old_password')
            ]);
        } catch (ModelNotFoundException $ex) {
            return view('user-profile')->withErrors($ex->getMessage());
        }
    }
}
