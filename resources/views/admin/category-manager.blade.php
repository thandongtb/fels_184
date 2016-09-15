@extends('layouts.admin')

@section('title')
    {{ trans('admin/categories.categories_manage_title') }}
@endsection

@section('content')
 <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">{{ trans('admin/categories.categories_manage_title') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <strong>{{ trans('admin/categories.all_categories') }}</strong>
                    <span class="pull-right">
                        {!! link_to_action('Admin\CategoriesController@create',
                            trans('admin/categories.create'), null, ['class' => 'btn btn-success']) !!}
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
                                <th>{{ trans('admin/categories.category_id') }}</th>
                                <th>{{ trans('admin/categories.category_name') }}</th>
                                <th>{{ trans('admin/categories.description') }}</th>
                                <th>{{ trans('admin/categories.edit') }}</th>
                                <th>{{ trans('admin/categories.delete') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $key => $category)
                                <tr class="odd gradeX">
                                    <td>{{ $category->id }}</td>
                                    <td>
                                        <a href="{{ action('Admin\CategoriesController@show',
                                        ['id' => $category->id]) }}">{{ $category->name }}</a>
                                    </td>
                                    <td>{{ $category->description }}</td>
                                    <td>
                                        {!! link_to_route('categories.edit', trans('admin/categories.edit'),
                                            [$category->id], ['class' => 'btn btn-primary']) !!}
                                    </td>
                                    <td>
                                        {!! Form::open(['method' => 'delete', 'route' => ['categories.destroy',
                                            $category->id] ]) !!}
                                            {{ Form::button(trans('admin/categories.delete'), ['type' => 'submit',
                                                'class' => 'btn btn-danger',
                                                'onclick' => 'return confirm("' . trans('admin/categories.delete_warning') . '")']) }}
                                        {{ Form::close() }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="text-center">
                        {!! $categories->render() !!}
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
