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
                <h1 class="page-header text-center">{{ $title . $user->name}}</h1>
            @else
                <h1 class="page-header text-center">{{ trans('activity.list_activity_title') }}</h1>
            @endif
        </div>
    </div>
    @include('layouts.message')
    <div id="home-url" data-url="{{ action('HomeController@index') }}"></div>
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="text-center">
                <a href="{{ action('ActivitiesController@index') }}">
                    <button class="btn btn-primary">{{ trans('activity.all_user') }}</button>
                </a>
                <a href="{{ action('ActivitiesController@showFollowingUserActivities', ['id' => Auth::user()->id] ) }}">
                    <button class="btn btn-success">{{ trans('activity.activity_following_list') }}</button>
                </a>
                <a href="{{ action('ActivitiesController@showUserFollowersActivities', ['id' => Auth::user()->id]) }}">
                    <button class="btn btn-danger">{{ trans('activity.activity_follower_list') }}</button>
                </a>
            </div>
            <hr>
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover table-responsive" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>{{ trans('activity.activity_id') }}</th>
                                <th>{{ trans('activity.user_name') }}</th>
                                <th>{{ trans('activity.target_type') }}</th>
                                <th>{{ trans('activity.reference_name') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                @if (count($user->activities) == 0)
                                    <tr class="odd gradeX">
                                        <td></td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ trans('activity.no_activity') }}</td>
                                        <td></td>
                                    </tr>
                                @else
                                    @foreach ($user->activities as $activity)
                                        <tr class="odd gradeX">
                                            <td>{{ $activity->id }}</td>
                                            <td>{{ $activity->user->name }}</td>
                                            <td>{{ trans('activity.target_content_' . $activity->target_id) }}</td>
                                            <td>
                                                <a href="{{ $activity->linkToObject() }}">
                                                    {{ isset($activity->object()->first()->name) ? $activity->object()->first()->name : $activity->object()->first()->content }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
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
    {!! Html::script('js/activity_list.js') !!}
    {!! Html::script('bower/toastr/toastr.js') !!}
@endsection
