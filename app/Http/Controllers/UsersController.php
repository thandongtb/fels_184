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
        $this->middleware('auth');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
        ]);
    }

    protected function validatorPassword(array $data)
    {
        return Validator::make($data, [
            'password' => 'required|min:6|confirmed',
        ]);
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

            return view('user-update', compact('user'));
        } catch (ModelNotFoundException $ex) {
            return view('user-profile')->withErrors($ex->getMessage());
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
        $data = $request->only('name', 'email');
        $validator = $this->validator($data);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->all());
        }

        try {
            $result = User::find($id)->update($data);

            if ($result) {
                return redirect()->to(action('UsersController@show', ['id' => $id]));
            }
        } catch (Exception $e) {
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
