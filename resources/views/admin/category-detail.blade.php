@extends('layouts.admin')

@section('title')
    {{ trans('admin/categories.category_detail_title') }}
@endsection

@section('content')

<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">{{ trans('admin/categories.category_detail_title') }}</h1>
        </div>
    </div>

    @include('layouts.errors')
    @include('layouts.success')

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
                                    <tr>
                                        <td>{{ trans('admin/categories.category_id') }}:</td>
                                        <td>{{ $category->id }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/categories.name') }}:</td>
                                        <td>{{ $category->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/categories.description') }}:</td>
                                        <td>{{ $category->description }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/categories.lessons') }}:</td>
                                        <td><a href="#">{{ trans('admin/categories.number') }}</a></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/categories.words') }}:</td>
                                        <td><a href="#">{{ trans('admin/categories.number') }}</a></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/categories.created_at') }}:</td>
                                        <td>{{ $category->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/categories.updated_at') }}:</td>
                                        <td>{{ $category->updated_at }}</td>
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
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
