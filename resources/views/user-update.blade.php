@extends('layouts.app')

@section('content')

<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <h1 class="page-header text-center">{{ trans('admin/users.user_edit_title') }}</h1>
        </div>
    </div>

    @include('layouts.message')

    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            {!! Form::model($user, ['route' => ['user.update', $user->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3 col-lg-3 " align="center">
                                <img alt="User Pic" src="https://pickaface.net/gallery/avatar/unr_hehe_160911_2042_qfuo9sh.png" class="img-circle img-responsive">
                            </div>
                            <div class=" col-md-9 col-lg-9 ">
                                <table class="table table-user-information">
                                    <tbody>
                                        <tr>
                                            <td>{{ trans('admin/users.user_id') }}:</td>
                                            <td>{{ $user->id }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('admin/users.name') }}:</td>
                                            <td>{!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => trans('admin/users.your_name')]) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('admin/users.email') }}:</td>
                                            <td>{!! Form::text('email', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => trans('admin/users.your_email')]) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('admin/users.change_password') }}:</td>
                                            <td>
                                                <a href="{{ action('UsersController@getResetPasswordForm', ['id' => $user->id]) }}">
                                                    {{ trans('admin/users.change_password') }}
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="panel-footer text-center">
                        {!! Form::button('<i class="fa fa-pencil-square"></i> ' . trans('admin/users.update'), ['type' => 'submit', 'class' => 'btn btn-warning']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection
