@extends('layouts.admin')

@section('title')
    {{ trans('admin/users.user_following_title') }}
@endsection

@section('content')
 <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">{{ trans('admin/users.user_following_title') }}</h1>
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
                                <td><strong>{{ trans('admin/users.following') }}:</strong></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover table-responsive" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>{{ trans('admin/users.user_id') }}</th>
                                <th>{{ trans('admin/users.user_name') }}</th>
                                <th>{{ trans('admin/users.email') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr class="odd gradeX">
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        <a href="{{ action('Admin\UsersController@show', ['id' => $user->id]) }}">
                                            {{ $user->name }}
                                        </a>
                                    </td>
                                    <td>{{ $user->email }}</td>
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
