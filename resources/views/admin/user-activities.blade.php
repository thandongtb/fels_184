@extends('layouts.admin')

@section('title')
    {{ trans('admin/users.user_activities_title') }}
@endsection

@section('content')
 <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">{{ trans('admin/users.user_activities_title') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
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
                                <td><strong>{{ trans('admin/users.activities') }}:</strong></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover table-responsive" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>{{ trans('activity.activity_id') }}</th>
                                <th>{{ trans('activity.target_type') }}</th>
                                <th>{{ trans('activity.reference_name') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $key => $activity)
                                <tr class="odd gradeX">
                                    <td>{{ $activity->id }}</td>
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
