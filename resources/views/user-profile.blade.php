@extends('layouts.app')

@section('css')
    {!! Html::style('css/user.css') !!}
    {!! Html::style('bower/toastr/toastr.css') !!}
@endsection()

@section('content')

<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <h1 class="page-header text-center">{{ trans('admin/users.user_profile_title') }}</h1>
        </div>
    </div>

    @include('layouts.message')

    <div id="home-url" data-url="{{ action('HomeController@index') }}"></div>

    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3 col-lg-3 " align="center">
                            <img alt="{{ $user->name }}" src="{{ is_null($user->avatar) ? config('user.avatar.default_url') : $user->getAvatarUrl() }}" class="img-circle img-responsive">
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
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/users.email') }}:</td>
                                        <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/users.role') }}:</td>
                                        <td>
                                            @if ($user->isAdmin())
                                                {{ trans('admin/users.admin') }}
                                            @else
                                                {{ trans('admin/users.user') }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('homepage.type_register_title') }}:</td>
                                        <td>
                                            {{ $user->typeRegister() }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/users.create_at') }}:</td>
                                        <td>{{ $user->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/users.is-follow') }}:</td>
                                        @if (Auth::user()->isFollowingAnother($user))
                                            <th>
                                                <a class="btn-follow" data-follow="1" data-user-followed-id="{{ $user->id }}">
                                                    <i class="fa fa-check" aria-hidden="true"></i>
                                                </a>
                                            </th>
                                        @else
                                            <th class="text=center">
                                                <a class="btn-follow" data-follow="0" data-user-followed-id="{{ $user->id }}">
                                                    <i class="fa fa-times unfollow" aria-hidden="true"></i>
                                                </a>
                                            </th>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel-footer text-center">
                    @if ($user->isCurrent())
                        {!! link_to_route('user.edit', trans('admin/users.edit'), [$user->id], ['class' => 'btn btn-success']) !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
    {!! Html::script('js/user_list.js') !!}
    {!! Html::script('bower/toastr/toastr.js') !!}
@endsection
