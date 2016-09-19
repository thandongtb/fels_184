@extends('layouts.app')

@section('css')
    {!! Html::style('css/wordlist.css') !!}
    {!! Html::style('//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css') !!}
@endsection()

@section('content')
<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <h1 class="page-header text-center">{{ trans('admin/users.change_password_title') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            {!! Form::open(['action' => 'UsersController@resetPasssword', 'method' => 'POST']) !!}
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3 col-lg-3 " align="center">
                                <img alt="User Pic" src="https://pickaface.net/gallery/avatar/unr_hehe_160911_2042_qfuo9sh.png" class="img-circle img-responsive">
                            </div>
                            <div class=" col-md-9 col-lg-9 ">
                                <table class="table table-user-information">
                                    <tbody>
                                        {{ Form::hidden('invisible', $user->id, array('name' => 'id')) }}
                                        <tr>
                                            <td>{{ trans('admin/users.old_password') }}:</td>
                                            <td>{!! Form::password('old_password', ['class'=>'form-control']) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('admin/users.new_password') }}:</td>
                                            <td>{!! Form::password('password', ['class'=>'form-control']) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('admin/users.confirm_password_user') }}:</td>
                                            <td>{!! Form::password('password_confirmation', ['class'=>'form-control']) !!}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="panel-footer text-center">
                        {!! Form::button('<i class="fa fa-pencil-square"></i> ' . trans('admin/users.change_password'), ['type' => 'submit', 'class' => 'btn btn-warning']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@section('js')
    {!! Html::script('js/wordlist.js') !!}
@endsection
