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
                            <h2>{{ trans('homepage.lesson-message.learned') }} </h2>
                            <div class="fix single-home-content-container">

                                <h2><i class="fa fa-angle-double-down"></i> {{ trans('homepage.lesson-message.result-of') }} {{ $lesson->name }}</h2>

                            </div>
                            <div class="table-container">
                                <table class="table table-filter display" id="table-filter">
                                    <tbody>
                                    @foreach ($dataResult as $key => $result)
                                        <tr>
                                            <td>
                                                <a href="javascript:;" class="star">
                                                    <i class="glyphicon glyphicon-star"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="media col-md-12">
                                                    <div class="col-md-3">
                                                        <a href="{{ action('WordsController@show', ['id' => $result->answer->word_id]) }}">
                                                            {{ $result->answer->word->content }}
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <span class="media-meta pull-right"></span>
                                                        <h4 class="title text-justify">
                                                            <i>
                                                                @if ($result->answer->isCorrect())
                                                                    <div class="correct-answer-text">{{ $result->answer->content }}</div>
                                                                    <span class="pull-right pagado correct-answer">{{ trans('homepage.lesson-message.correct-answer') }}</span>
                                                                @else
                                                                <div class="wrong-answer-text">{{ $result->answer->content }}</div>
                                                                <span class="pull-right pagado wrong-answer">{{ trans('homepage.lesson-message.wrong-answer') }}</span>
                                                                @endif

                                                            </i>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach()
                                    </tbody>
                                </table>
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
