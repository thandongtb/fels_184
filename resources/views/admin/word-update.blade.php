@extends('layouts.admin')

@section('title')
    {{ trans('admin/words.word_edit_title') }}
@endsection

@section('style')
    {!! Html::style('css/admin.css') !!}
@endsection

@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">{{ trans('admin/words.word_edit_title') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            {!! Form::model($word, [
                'route' => ['words.show', $word->id],
                'method' => 'PUT',
                'class' => 'form-horizontal',
                'id' => 'create-word',
            ]) !!}

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('admin/words.word_info') }}</h3>
                </div>
                <!-- /.panel-heading -->

                <div class="panel-body">
                    <div class="form-group">
                        <table class="table table-category-information">
                            <tbody>
                                <tr>
                                    <td>{{ trans('admin/words.word_category') }}:</td>
                                    <td>
                                        {{ Form::select(
                                            'category_id', $categories,
                                            $word->category->name, [
                                            'class' => 'form-control'
                                        ]) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ trans('admin/words.word_content') }}:</td>
                                    <td>
                                        {!! Form::text('word_content', $word->content, [
                                            'class' => 'form-control',
                                            'placeholder' => 'Word Content'
                                        ]) !!}
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
                        <div class="col-md-10" id="option-wrap">
                            @foreach ($answers as $key => $answer)
                                <table class="table table-striped table-bordered table-responsive">
                                    <tr>
                                        <td>{{ trans('admin/words.word_answer') }}</td>
                                        <td>
                                            {!! Form::text('answers[content][]',
                                                 $answer->content,
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
                                                $answer->is_correct, [
                                                    'class' => 'form-control',
                                                    'placeholder' => trans('admin/words.is_correct')
                                            ]) !!}
                                        </td>
                                    </tr>
                                </table>
                            @endforeach
                        </div>
                    </div>
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

            </div>
            <!-- /Answers -->

            {!! Form::close() !!}

        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->
@endsection
