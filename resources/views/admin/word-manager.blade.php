@extends('layouts.admin')

@section('title')
    {{ trans('admin/words.words_manage_title') }}
@endsection

@section('content')
 <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">{{ trans('admin/words.words_manage_title') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <strong>{{ trans('admin/words.all_words') }}</strong>
                    <span class="pull-right">
                        {!! link_to_action('Admin\WordsController@create',
                            trans('admin/words.create'), null, ['class' => 'btn btn-success']) !!}
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
                                <th>{{ trans('admin/words.word_id') }}</th>
                                <th>{{ trans('admin/words.word_content') }}</th>
                                <th>{{ trans('admin/words.word_category') }}</th>
                                <th>{{ trans('admin/words.created_at') }}</th>
                                <th>{{ trans('admin/words.updated_at') }}</th>
                                <th>{{ trans('admin/words.edit') }}</th>
                                <th>{{ trans('admin/words.delete') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($words as $key => $word)
                                <tr class="odd gradeX">
                                    <td>{{ $word->id }}</td>
                                    <td>
                                        <a href="{{ action('Admin\WordsController@show', ['id' => $word->id]) }}">
                                            {{ $word->content }}
                                        </a>
                                    </td>
                                    <td>{{ $word->category->name }}</td>
                                    <td>{{ $word->created_at }}</td>
                                    <td>{{ $word->updated_at }}</td>
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
                            @endforeach
                        </tbody>
                    </table>

                    <div class="text-center">
                        {!! $words->render() !!}
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
