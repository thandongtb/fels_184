@extends('layouts.admin')

@section('title')
    {{ trans('admin/lessons.lesson_detail_title') }}
@endsection

@section('content')
 <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">{{ trans('admin/lessons.lesson_detail_title') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <span class="pull-right">
                        <table>
                            <tr>
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
                                        ]
                                    ]) !!}
                                        {{ Form::button(trans('admin/lessons.delete'), [
                                            'type' => 'submit',
                                            'class' => 'btn btn-danger',
                                            'onclick' => 'return confirm("' . trans('admin/lessons.delete_warning') . '")'
                                        ]) }}
                                    {{ Form::close() }}
                                </td>
                            </tr>
                        </table>
                    </span>
                </div>
                <!-- /.panel-heading -->

                @include('layouts.errors')
                @include('layouts.success')

                <div class="panel-body">
                    <table class="table table-category-information">
                        <tbody>
                            <tr>
                                <td>{{ trans('admin/lessons.lesson_id') }}:</td>
                                <td>{{ $lesson->id }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin/lessons.category') }}:</td>
                                <td>
                                    <a href="{{ action('Admin\CategoriesController@show',
                                        ['id' => $lesson->category_id]) }}">
                                        {{ $lesson->category->name }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin/lessons.lesson') }}:</td>
                                <td><strong>{{ $lesson->name }}</strong></td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin/lessons.words') }}:</td>
                                <td>
                                    <ul>
                                        @foreach ($lessonWords as $key => $lessonWord)
                                            <li>
                                                <a href="{{ action('Admin\WordsController@show',
                                                    ['id' => $lessonWord->word->id]) }}">
                                                    {{ $lessonWord->word->content }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
