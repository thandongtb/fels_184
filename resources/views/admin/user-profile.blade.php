@extends('layouts.admin')

@section('title')
    {{ trans('admin/users.user_profile_title') }}
@endsection

@section('content')

<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">{{ trans('admin/users.user_profile_title') }}</h1>
        </div>
    </div>

    @include('layouts.errors')
    @include('layouts.success')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
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
                                        <td>{{ trans('admin/users.create_at') }}:</td>
                                        <td>{{ $user->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/users.update_at') }}:</td>
                                        <td>{{ $user->updated_at }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <a href="{{ action('Admin\UsersController@showFollowingUser',
                                                ['id' => $user->id]) }}">
                                                <button class="btn btn-info">
                                                    {{ trans('admin/users.user_following') }}
                                                </button>
                                            </a>
                                            <a href="{{ action('Admin\UsersController@showUserFollowers',
                                                ['id' => $user->id]) }}">
                                                <button class="btn btn-info">
                                                    {{ trans('admin/users.user_follower') }}
                                                </button>
                                            </a>
                                            <a href="{{ action('Admin\ActivitiesController@show',
                                                ['id' => $user->id]) }}">
                                                <button class="btn btn-info">
                                                    {{ trans('admin/users.user_activities') }}
                                                </button>
                                            </a>
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
                                {!! link_to_route('users.edit', trans('admin/users.edit'), [$user->id],
                                    ['class' => 'btn btn-primary']) !!}
                            </td>
                            @if (!$user->isAdmin())
                                <td>
                                    {!! Form::open(['method' => 'delete', 'route' => ['users.destroy', $user->id] ]) !!}
                                        {{ Form::button(trans('admin/users.delete'), [
                                            'type' => 'submit',
                                            'class' => 'btn btn-danger',
                                            'onclick' => 'return confirm("' . trans('admin/users.delete_warning') . '")'
                                        ]) }}
                                    {{ Form::close() }}
                                </td>
                            @endif
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
