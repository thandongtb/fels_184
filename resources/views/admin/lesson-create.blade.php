@extends('layouts.admin')

@section('title')
    {{ trans('admin/lessons.lesson_create_title') }}
@endsection

@section('content')
 <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">{{ trans('admin/lessons.lesson_create_title') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">

                @include('layouts.errors')
                @include('layouts.success')

                {!! Form::open([
                    'route' => 'lessons.store',
                    'method' => 'POST',
                    'class' => 'form-horizontal',
                ]) !!}

                <div class="panel-body">
                    <table class="table table-category-information">
                        <tbody>
                            <tr>
                                <td><strong>{{ trans('admin/lessons.category') }}:</strong></td>
                                <td>
                                    {!! Form::select('lesson_category', $categories, null, [
                                        'class' => 'form-control',
                                        'placeholder' => 'Choose Category ...'
                                    ]) !!}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('admin/lessons.name') }}:</strong></td>
                                <td>
                                    {!! Form::text('lesson_name', null, [
                                        'class' => 'form-control',
                                        'placeholder' => trans('admin/categories.category_name')
                                    ]) !!}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>{{ trans('admin/lessons.word_number') }}:</strong></td>
                                <td>
                                    {!! Form::number('word_number') !!}
                                </td>
                                {{ csrf_field() }}
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.panel-body -->

                <div class="panel-footer">
                    <table>
                        <tr>
                            <td>
                                {!! Form::button('<i class="fa fa-pencil-square"></i> ' . trans('admin/lessons.create'),
                                    ['type' => 'submit', 'class' => 'btn btn-success'])
                                !!}
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
