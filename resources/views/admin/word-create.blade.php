@extends('layouts.admin')

@section('title')
    {{ trans('admin/words.word_create_title') }}
@endsection

@section('style')
    {!! Html::style('css/admin.css') !!}
@endsection

@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">{{ trans('admin/words.word_create_title') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            {!! Form::open([
                'route' => 'words.store',
                'method' => 'POST',
                'class' => 'form-horizontal',
            ]) !!}

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('admin/words.word_info') }}</h3>
                </div>
                <!-- /.panel-heading -->

                <div class="panel-body">
                    <div class="form-group">
                        <table class="table table-answer">
                            <tbody>
                                <tr>
                                    <td>{{ trans('admin/words.word_category') }}:</td>
                                    <td>
                                        {{ Form::select('category_id', $categories, null, [
                                            'class' => 'form-control',
                                            'placeholder' => trans('admin/words.pick_category')
                                        ]) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ trans('admin/words.word_content') }}:</td>
                                    <td>
                                        {!! Form::text('word_content', null, [
                                            'class' => 'form-control',
                                            'placeholder' => trans('admin/words.word_content')
                                        ]) !!}
                                        {{ csrf_field() }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('admin/words.word_answers') }}</h3>
                </div>
                <!-- /.panel-heading -->

                <div class="panel-body">
                    <div class="form-group">
                        <div id="option-wrap">
                            <div class="col-md-10">
                                <table class="table table-word-answer">
                                    <tbody>
                                        <tr>
                                            <td>{{ trans('admin/words.word_answer') }}</td>
                                            <td>
                                                {!! Form::text('answers[content][]', null,
                                                    ['class' => 'form-control']
                                                ) !!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('admin/words.word_is_correct') }}</td>
                                            <td>
                                                {!! Form::select('answers[is_correct][]', [
                                                    config('word.answer.correct') => trans('admin/words.word_true'),
                                                    config('word.answer.not_correct') => trans('admin/words.word_false')],
                                                    null, [
                                                        'class' => 'form-control',
                                                        'placeholder' => trans('admin/words.is_correct')
                                                ]) !!}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <tr>
                        <td>
                            {!! Form::button(trans('admin/words.add_answer'), [
                                'type' => 'button',
                                'class' => 'btn btn-info new-option',
                                'id' => 'new-option',
                            ]) !!}
                        </td>
                        <td>
                            {!! Form::button(trans('admin/words.remove_answer'), [
                                'type' => 'button',
                                'class' => 'btn btn-danger remove-option',
                                'id' => 'remove-option ',
                            ]) !!}
                        </td>
                    </tr>

                </div>
                <!-- /.panel-body -->

                <div class="panel-footer">
                    <table>
                        <tr>
                            <td>
                                {!! Form::button(
                                    '<i class="fa fa-pencil-square"></i> ' . trans('admin/words.create'),
                                    ['type' => 'submit', 'class' => 'btn btn-success btn-save']
                                ) !!}
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- /.panel-footer -->

            </div>
            <!-- /Answers -->

            {!! Form::close() !!}

            <div class="form-group hidden">
                <div class="col-md-10">
                    <table class="table table-word-answer table-add-answer">
                        <tbody>
                            <tr>
                                <td>{{ trans('admin/words.word_answer') }}</td>
                                <td>
                                    {!! Form::text('answers[content][]', null,
                                        ['class' => 'form-control']
                                    ) !!}
                                </td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin/words.word_is_correct') }}</td>
                                <td>
                                    {!! Form::select('answers[is_correct][]', [
                                        config('word.answer.correct') => trans('admin/words.word_true'),
                                        config('word.answer.not_correct') => trans('admin/words.word_false')],
                                        null, [
                                            'class' => 'form-control',
                                            'placeholder' => trans('admin/words.is_correct')
                                    ]) !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->
@endsection

@section('script')
    {!! Html::script('js/admin.js') !!}
@endsection
