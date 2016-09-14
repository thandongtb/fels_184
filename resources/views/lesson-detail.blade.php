@extends('layouts.app')

@section('css')
    {!! Html::style('css/lesson.css') !!}
    {!! Html::style('//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css') !!}
@endsection()

@section('content')
<div class="container">
    <div class="row">
        <div class="text-center">
            <div class="fix main-content-area">
                <div class="fix centre main-content">
                    <div class="fix home-content floatleft">
                        <div class="fix single-home-content">
                            <div class="fix single-home-content-container">
                                <h2><i class="fa fa-angle-double-down"></i> {{ trans('homepage.lesson-message.lesson') }} {{ $lesson->name }} </h2>
                                <div id="data-lesson" data-lesson="{{ $lesson->id }}" data-questions="{{ $questions }}"></div>
                                <div id="lesson-frame" role="content">
                                    <button class="btn btn-primary" id="start-lesson">{{ trans('lesson.button.start_lesson') }}</button>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End home content-->
                </div>
            </div> <!-- End main content-->
        </div>
    </div>
</div>
@endsection

@section('js')
    {!! Html::script('js/lesson.js') !!}
@endsection
