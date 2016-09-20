@extends('layouts.admin')

@section('title')
    {{ trans('admin/users.activities_manage_title') }}
@endsection

@section('content')
 <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">{{ trans('admin/users.activities_all_title') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
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
                    @foreach ($activities as $key => $activity)
                        <tr class="odd gradeX">
                            <td>{{ $activity->id }}</td>
                            <td>
                                <a href="{{ action('Admin\UsersController@show', ['id' => $activity->user->id]) }}">
                                    {{ $activity->user->name }}
                                </a>
                            </td>
                            <td>{{ trans('activity.target_content_' . $activity->target_id) }}</td>
                            <td>
                                <a href="{{ $activity->linkToObject() }}">
                                    {{ isset($activity->object()->first()->name) ? $activity->object()->first()->name : $activity->object()->first()->content }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-center">
                {!! $activities->render() !!}
            </div>

        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->
@endsection
