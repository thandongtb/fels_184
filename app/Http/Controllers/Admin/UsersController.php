<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Auth;
use App\Http\Requests\UpdateUserRequest;

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
        $userData = User::find($id);

        if ($userData) {
            return view('admin.user-profile', compact('userData'));
        }

        return redirect()->action('Admin\UsersController@index')->withErrors(trans('admin/users.error_message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userData = User::find($id);

        if ($userData) {
            return view('admin.user-update', compact('userData'));
        }

        return redirect()->action('Admin\UsersController@index')->withErrors(trans('admin/users.error_message'));
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
        $userData = User::find($id);

        if ($userData) {
            $userData->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ]);

            if ($userData->save()) {
                return redirect()->action('Admin\UsersController@show', compact('userData'))->withSuccess(trans('admin/users.user_update_success'));
            }

            return redirect()->action('Admin\UsersController@show', compact('userData'))->withErrors(trans('admin/users.user_update_errors'));
        }

        return redirect()->action('Admin\UsersController@index')->withErrors(trans('admin/users.error_message'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userData = User::find($id);

        if ($userData) {
            if ($userData->delete()) {
                return redirect()->action('Admin\UsersController@index')->withSuccess(trans('admin/users.user_delete_success'));
            }

            return redirect()->back()->withErrors(trans('admin/users.user_delete_fail'));
        }

        return redirect()->action('Admin\UsersController@index')->withErrors(trans('admin/users.error_message'));
    }
}
