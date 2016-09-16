@extends('layouts.admin')

@section('title')
    {{ trans('admin/words.word_detail_title') }}
@endsection

@section('content')
 <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">{{ trans('admin/words.word_detail_title') }}</h1>
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
                                    {!! link_to_route('words.edit', trans('admin/words.edit'),
                                        [$word->id], ['class' => 'btn btn-primary']) !!}
                                </td>
                                <td>
                                    {!! Form::open([
                                        'method' => 'delete',
                                        'route' => [
                                            'words.destroy',
                                            $word->id
                                        ]
                                    ]) !!}
                                        {{ Form::button(trans('admin/words.delete'), [
                                            'type' => 'submit',
                                            'class' => 'btn btn-danger',
                                            'onclick' => 'return confirm("' . trans('admin/words.delete_warning') . '")'
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
                                <td>{{ trans('admin/words.word_id') }}:</td>
                                <td>{{ $word->id }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin/words.word_category') }}:</td>
                                <td>
                                    <a href="{{ action('Admin\CategoriesController@show',
                                        ['id' => $word->category_id]) }}">
                                        {{ $word->category->name }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin/words.word_content') }}:</td>
                                <td><strong>{{ $word->content }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-striped table-bordered table-hover table-responsive"
                    id="dataTables-example">
                        <thead>
                            <tr>
                                <th>{{ trans('admin/words.word_answers') }}</th>
                                <th>{{ trans('admin/words.word_is_correct') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($word->answers as $answer)
                                <tr>
                                    <td>{{ $answer->content }}</td>
                                    <td>
                                        @if ($answer->is_correct)
                                            {{ trans('admin/words.word_true') }}
                                        @else
                                            {{ trans('admin/words.word_false') }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
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
