@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('auth.login') }}</div>
                <div class="panel-body">
                    {{ Form::open(['url' => '/login', 'class' => 'form-horizontal']) }}
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            {{ Form::label('email', trans('auth.email'), ['class' => 'col-md-4 control-label']) }}

                            <div class="col-md-6">
                                {{ Form::email('email', old('email'), ['class' => 'form-control']) }}

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            {{ Form::label('password', trans('auth.password'), ['class' => 'col-md-4 control-label']) }}

                            <div class="col-md-6">
                                {{ Form::password('password', ['id' => 'password', 'class' => 'form-control']) }}

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('remember') }}
                                        {{ trans('auth.remember') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">

                                {{ Form::button('<i class="fa fa-btn fa-sign-in"></i>' . trans('auth.login'), ['type' => 'submit', 'class' => 'btn btn-success']) }}

                                <a class="btn btn-social-icon btn-facebook" href="{{ URL('social/redirect/facebook') }}">
                                    <span class="fa fa-facebook"></span>
                                </a>
                                <a class="btn btn-social-icon btn-twitter" href="{{ URL('social/redirect/twitter') }}">
                                    <span class="fa fa-twitter"></span>
                                </a>
                                <a class="btn btn-social-icon btn-google" href="{{ URL('social/redirect/google') }}">
                                    <span class="fa fa-google"></span>
                                </a>
                                <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                    {{ trans('auth.forget_password') }}
                                </a>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
