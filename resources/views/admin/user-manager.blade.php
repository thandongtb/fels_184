@extends('layouts.admin')

@section('title')
    {{ trans('admin/users.users_manage_title') }}
@endsection

@section('content')
 <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">{{ trans('admin/users.users_manage_title') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('admin/users.all_users') }}</div>

                @include('layouts.errors')
                @include('layouts.success')

                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover table-responsive" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>{{ trans('admin/users.user_id') }}</th>
                                <th>{{ trans('admin/users.user_name') }}</th>
                                <th>{{ trans('admin/users.email') }}</th>
                                <th>{{ trans('admin/users.user_follower') }}</th>
                                <th>{{ trans('admin/users.user_followed') }}</th>
                                <th>{{ trans('admin/users.role') }}</th>
                                <th>{{ trans('admin/users.create_at') }}</th>
                                <th>{{ trans('admin/users.edit') }}</th>
                                <th>{{ trans('admin/users.delete') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr class="odd gradeX">
                                    <td>{{ $user->id }}</td>
                                    <td><a href="{{ URL('admin/users/' . $user->id) }}">{{ $user->name }}</a></td>
                                    <td>{{ $user->email }}</td>
                                    <td><a href="#">{{ trans('admin/users.number') }}</a></td>
                                    <td><a href="#">{{ trans('admin/users.number') }}</a></td>
                                    <th>
                                        @if ($user->isAdmin())
                                            {{ trans('admin/users.admin') }}
                                        @else
                                            {{ trans('admin/users.user') }}
                                        @endif
                                    </th>
                                    <td>{{ $user->created_at }}</td>
                                    <th>
                                        {!! link_to_route('users.edit', trans('admin/users.edit'), [$user->id], ['class' => 'btn btn-primary']) !!}
                                    </th>
                                    @if (!$user->isCurrent())
                                        <th>
                                            {!! Form::open(['method' => 'delete', 'route' => ['users.destroy', $user->id] ]) !!}
                                                {{ Form::button(trans('admin/users.delete'), ['type' => 'submit', 'class' => 'btn btn-danger', 'onclick' => "return confirm(trans('admin/users.delete_warning'))"]) }}
                                            {{ Form::close() }}
                                        </th>
                                    @else
                                        <th></th>
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
