@extends('layouts.admin')

@section('title')
    {{ trans('admin/categories.category_edit_title') }}
@endsection

@section('content')

<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">{{ trans('admin/categories.category_edit_title') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3 col-lg-3" align="center">
                            <img alt="category Pic" src="{{ $category->getPhotoUrl() }}"
                            class="img-responsive">
                        </div>
                        <div class="col-md-9 col-lg-9">
                            <table class="table table-category-information">
                                <tbody>
                                    {!! Form::model($category, ['route' => ['categories.show',
                                        $category->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
                                    <tr>
                                        <td>{{ trans('admin/categories.category_id') }}:</td>
                                        <td>{{ $category->id }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/categories.name') }}:</td>
                                        <td>
                                            {!! Form::text('name', null, ['class' => 'form-control',
                                                'placeholder' => trans('admin/categories.category_name')]) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/categories.description') }}:</td>
                                        <td>
                                            {!! Form::textarea('description', null, ['class' => 'form-control',
                                                'placeholder' => trans('admin/categories.description')]) !!}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel-footer">
                    <table>
                        <tr>
                            <td>
                                {!! Form::button('<i class="fa fa-pencil-square"></i> ' . trans('admin/categories.update'),
                                    ['type' => 'submit', 'class' => 'btn btn-success']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
