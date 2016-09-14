@extends('layouts.admin')

@section('title')
    {{ trans('admin/categories.category_create_title') }}
@endsection

@section('content')

<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">{{ trans('admin/categories.category_add_new') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3 col-lg-3" align="center">
                            <img alt="category Pic" src="{{ asset(config('common.category.path.default_photo_url')) }}"
                            class="img-responsive">
                        </div>
                        <div class="col-md-9 col-lg-9">
                            <table class="table table-category-information">
                                <tbody>
                                    {!! Form::open(['route' => 'categories.store', 'method' => 'POST',
                                        'class' => 'form-horizontal', 'files' => true]) !!}
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
                                    <tr>
                                        <td>{{ trans('admin/categories.category_photo') }}:</td>
                                        <td>{!! Form::file('photo') !!}</td>
                                    </tr>
                                    {{ csrf_field() }}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel-footer">
                    <table>
                        <tr>
                            <td>
                                {!! Form::button('<i class="fa fa-pencil-square"></i> ' . trans('admin/categories.create'),
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
