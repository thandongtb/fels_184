@extends('layouts.admin')

@section('title')
    {{ trans('admin/lessons.lesson_edit_title') }}
@endsection

@section('content')
 <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">{{ trans('admin/lessons.lesson_edit_title') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">

                @include('layouts.errors')
                @include('layouts.success')

                {!! Form::model($lesson, [
                    'route' => ['lessons.show', $lesson->id],
                    'method' => 'PUT',
                    'class' => 'form-horizontal',
                ]) !!}

                <div class="panel-body">
                    <table class="table table-category-information">
                        <tbody>
                            <tr>
                                <td>{{ trans('admin/lessons.lesson_id') }}:</td>
                                <td>{{ $lesson->id }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin/lessons.category') }}:</td>
                                <td>{{ $lesson->category->name }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin/lessons.lesson') }}:</td>
                                <td>
                                    {!! Form::text('lesson_name', $lesson->name, [
                                        'class' => 'form-control',
                                        'placeholder' => trans('admin/lessons.lesson_name')
                                    ]) !!}
                                </td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin/lessons.words') }}:</td>
                                <td>
                                    <ul class="list-group">
                                        @foreach ($lessonWords as $lessonWord)
                                            <li class="list-group-item">
                                                {!! Form::select('lessonWord[]', $words,
                                                    $lessonWord->word->id, [
                                                    'class' => 'form-control'
                                                ]) !!}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.panel-body -->

                <div class="panel-footer">
                    <table>
                        <tr>
                            <td>
                                {!! Form::button(
                                    '<i class="fa fa-pencil-square"></i> ' . trans('admin/words.update'),
                                    ['type' => 'submit', 'class' => 'btn btn-success btn-save']
                                ) !!}
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- /.panel-footer -->

                {!! Form::close() !!}

            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->
@endsection
