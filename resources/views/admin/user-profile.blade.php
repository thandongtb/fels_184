@extends('layouts.admin')

@section('title')
    {{ trans('admin/users.user_profile_title') }}
@endsection

@section('content')

<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">{{ trans('admin/users.user_profile_title') }}</h1>
        </div>
    </div>

    @include('layouts.errors')
    @include('layouts.success')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="https://pickaface.net/gallery/avatar/unr_hehe_160911_2042_qfuo9sh.png" class="img-circle img-responsive"> </div>
                        <div class=" col-md-9 col-lg-9 ">
                            <table class="table table-user-information">
                                <tbody>
                                    <tr>
                                        <td>{{ trans('admin/users.user_id') }}:</td>
                                        <td>{{ $userData->id }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/users.name') }}:</td>
                                        <td>{{ $userData->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/users.email') }}:</td>
                                        <td><a href="mailto:{{ $userData->email }}">{{ $userData->email }}</a></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/users.user_follower') }}:</td>
                                        <td><a href="#">{{ trans('admin/users.number') }}</a></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/users.user_followed') }}:</td>
                                        <td><a href="#">{{ trans('admin/users.number') }}</a></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/users.user_activities') }}:</td>
                                        <td><a href="#">{{ trans('admin/users.number') }}</a></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/users.learned_lessons') }}:</td>
                                        <td><a href="#">{{ trans('admin/users.number') }}</a></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/users.learned_words') }}:</td>
                                        <td><a href="#">{{ trans('admin/users.number') }}</a></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/users.results') }}:</td>
                                        <td><a href="#">{{ trans('admin/users.number') }}</a></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/users.role') }}:</td>
                                        <td>
                                            @if ($userData->isAdmin())
                                                {{ trans('admin/users.admin') }}
                                            @else
                                                {{ trans('admin/users.user') }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('admin/users.create_at') }}:</td>
                                        <td>{{ $userData->created_at }}</td>
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
                                {!! link_to_route('users.edit', trans('admin/users.edit'), [$userData->id], ['class' => 'btn btn-primary']) !!}
                            </td>
                            @if (!$userData->isCurrent())
                                <td>
                                    {!! Form::open(['method' => 'delete', 'route' => ['users.destroy', $userData->id] ]) !!}
                                        {{ Form::button(trans('admin/users.delete'), ['type' => 'submit', 'class' => 'btn btn-danger', 'onclick' => "return confirm(trans('admin/users.delete_warning'))"]) }}
                                    {{ Form::close() }}
                                </td>
                            @endif
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
