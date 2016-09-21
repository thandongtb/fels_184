@extends('layouts.app')

@section('css')
    {!! Html::style('css/user.css') !!}
    {!! Html::style('bower/toastr/toastr.css') !!}
@endsection()

@section('content')
 <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            @if (isset($user))
                <h1 class="page-header text-center">{{ $title . $user->name }}</h1>
            @else
                <h1 class="page-header text-center">{{ trans('homepage.list-user.title') }}</h1>
            @endif
        </div>
    </div>
    @include('layouts.message')
    <div id="home-url" data-url="{{ action('HomeController@index') }}"></div>
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="text-center">
                <a href="{{ action('UsersController@showFollowingUser', ['id' => Auth::user()->id]) }}">
                    <button class="btn btn-primary">{{ trans('homepage.user_following_list') }}</button>
                </a>
                <a href="{{ action('UsersController@showUserFollowers', ['id' => Auth::user()->id]) }}">
                    <button class="btn btn-success">{{ trans('homepage.user_follower_list') }}</button>
                </a>
                <a href="{{ action('UsersController@index') }}">
                    <button class="btn btn-danger">{{ trans('homepage.all_user_list') }}</button>
                </a>
            </div>
            <hr>
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover table-responsive" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>{{ trans('admin/users.user_id') }}</th>
                                <th>{{ trans('admin/users.user_name') }}</th>
                                <th>{{ trans('admin/users.email') }}</th>
                                <th>{{ trans('admin/users.user_follower') }}</th>
                                <th>{{ trans('admin/users.user_following') }}</th>
                                <th>{{ trans('admin/users.role') }}</th>
                                <th>{{ trans('admin/users.create_at') }}</th>
                                <th>{{ trans('admin/users.edit') }}</th>
                                <th>{{ trans('admin/users.is-follow') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr class="odd gradeX">
                                    <td>{{ $user->id }}</td>
                                    <td><a href="{{ URL('user/' . $user->id) }}">{{ $user->name }}</a></td>
                                    <td>{{ $user->email }}</td>
                                    <td><a href="{{ action('UsersController@showFollowingUser', ['id' => $user->id]) }}">{{ trans('homepage.see_more') }}</a></td>
                                    <td><a href="{{ action('UsersController@showUserFollowers', ['id' => $user->id]) }}">{{ trans('homepage.see_more') }}</a></td>
                                    <th>
                                        @if ($user->isAdmin())
                                            {{ trans('admin/users.admin') }}
                                        @else
                                            {{ trans('admin/users.user') }}
                                        @endif
                                    </th>
                                    <td>{{ $user->created_at }}</td>
                                    @if ($user->isCurrent())
                                        <th>
                                            {!! link_to_route('user.edit', trans('admin/users.edit'), [$user->id], ['class' => 'btn btn-primary']) !!}
                                        </th>
                                    @else
                                        <th></th>
                                    @endif
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
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        {!! $users->render() !!}
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->
@endsection

@section('js')
    {!! Html::script('js/user_list.js') !!}
    {!! Html::script('bower/toastr/toastr.js') !!}
@endsection
