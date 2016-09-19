@extends('layouts.admin')

@section('title')
    {{ trans('admin/lessons.lessons_manage_title') }}
@endsection

@section('content')
 <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">{{ trans('admin/lessons.lessons_manage_title') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <strong>{{ trans('admin/lessons.all_lessons') }}</strong>
                    <span class="pull-right">
                        {!! link_to_action('Admin\LessonsController@create',
                            trans('admin/lessons.create'), null, ['class' => 'btn btn-success']) !!}
                    </span>
                </div>

                @include('layouts.errors')
                @include('layouts.success')

                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover table-responsive"
                    id="dataTables-example">
                        <thead>
                            <tr>
                                <th>{{ trans('admin/lessons.lesson_id') }}</th>
                                <th>{{ trans('admin/lessons.lesson') }}</th>
                                <th>{{ trans('admin/lessons.category') }}</th>
                                <th>{{ trans('admin/lessons.created_at') }}</th>
                                <th>{{ trans('admin/lessons.updated_at') }}</th>
                                <th>{{ trans('admin/lessons.edit') }}</th>
                                <th>{{ trans('admin/lessons.delete') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lessons as $key => $lesson)
                                <tr class="odd gradeX">
                                    <td>{{ $lesson->id }}</td>
                                    <td>
                                        <a href="{{ action('Admin\LessonsController@show', ['id' => $lesson->id]) }}">
                                            {{ $lesson->name }}
                                        </a>
                                    </td>
                                    <td>{{ $lesson->category->name }}</td>
                                    <td>{{ $lesson->created_at }}</td>
                                    <td>{{ $lesson->updated_at }}</td>
                                    <td>
                                        {!! link_to_route('lessons.edit', trans('admin/lessons.edit'),
                                            [$lesson->id], ['class' => 'btn btn-primary']) !!}
                                    </td>
                                    <td>
                                        {!! Form::open([
                                            'method' => 'delete',
                                            'route' => [
                                                'lessons.destroy',
                                                $lesson->id
                                        ]]) !!}
                                            {{ Form::button(trans('admin/lessons.delete'), [
                                                'type' => 'submit',
                                                'class' => 'btn btn-danger',
                                                'onclick' => 'return confirm("' . trans('admin/lessons.delete_warning') . '")'
                                            ]) }}
                                        {{ Form::close() }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="text-center">
                        {!! $lessons->render() !!}
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
