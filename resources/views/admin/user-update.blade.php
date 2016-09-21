@extends('layouts.admin')

@section('title')
    {{ trans('admin/users.user_edit_title') }}
@endsection

@section('content')

<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">{{ trans('admin/users.user_edit_title') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                @include('layouts.errors')
                @include('layouts.success')

                {!! Form::model($user, ['route' => ['users.show', $user->id], 'method' => 'PUT',
                    'class' => 'form-horizontal', 'files' => true
                ]) !!}

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="{{ $user->getAvatarUrl() }}" class="img-circle img-responsive"> </div>
                        <div class=" col-md-9 col-lg-9 ">
                            <table class="table table-user-information">
                                <tbody>
                                    <tr>
                                        <td>{{ trans('admin/users.user_id') }}:</td>
                                        <td>{{ $user->id }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/users.name') }}:</td>
                                        <td>
                                            {!! Form::text('name', null, [
                                                'class' => 'form-control',
                                                'placeholder' => trans('admin/users.your_name')
                                            ]) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/users.email') }}:</td>
                                        <td>
                                            {!! Form::text('email', null, [
                                                'class' => 'form-control',
                                                'placeholder' => trans('admin/users.your_email')
                                            ]) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/users.user_avatar') }}:</td>
                                        <td>{!! Form::file('avatar') !!}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/users.user_password') }}:</td>
                                        <td>{!! Form::password('password', ['class' => 'awesome']) !!}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/users.role') }}:</td>
                                        <td>
                                            {!! Form::select(trans('admin/users.user_role'), [
                                                config('user.role.user') => trans('admin/users.user'),
                                                config('user.role.admin') => trans('admin/users.admin')
                                            ]) !!}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel-footer">
                    <table>
                        <tr>
                            <td>
                                {!! Form::button('<i class="fa fa-pencil-square"></i>' . trans('admin/users.update'), [
                                    'type' => 'submit',
                                    'class' => 'btn btn-success'
                                ]) !!}
                            </td>
                        </tr>
                    </table>
                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>

@endsection
