@extends('layouts.app')

@section('css')
    {!! Html::style('css/wordlist.css') !!}
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
                                <h2><i class="fa fa-angle-double-down"></i> {{ $categoryTitle }} </h2>
                                @foreach ($lessons as $key => $lesson)

                                <div class="fix single-content floatleft">
                                    <img src="http://www.lawnsciencesouthmanchester.co.uk/images/blog/weeds/Daisy_flower.jpg"/>
                                    <a href="{{ action('LessonsController@show', ['id' => $lesson->id]) }}">
                                        <h2>{{ $lesson->name }} </h2>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                            {!! $lessons->appends(array_except(Request::query(), 'wordlist_page', 'page'))->render() !!}
                        </div>

                        <div class="fix single-home-blog-content">
                            <div class="fix single-blog-content_container">
                                <h2><i class="fa fa-hand-o-down"></i> {{ trans('homepage.word_menu') }} <a href="" class="floatright">{{ trans('homepage.see_all') }} <i class="fa fa-angle-double-right"></i></a></h2>
                                <div class="row">
                                    <section class="content">
                                        <div class="col-md-8 col-md-offset-2">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <div class="pull-right">
                                                        <div class="col-md-12">
                                                            <div class="col-md-3">
                                                                {{ Form::open(['url' => '/home', 'method' => 'GET', 'class' => 'form-horizontal']) }}
                                                                    {{ Form::hidden('type', config('word.filter.new'), ['class' => 'form-control']) }}
                                                                    {{ Form::hidden('page', $page, ['class' => 'form-control']) }}
                                                                    {{ Form::button(trans('homepage.new_word'), ['type' => 'submit', 'class' => 'btn btn-success']) }}
                                                                {{ Form::close() }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                {{ Form::open(['url' => '/home', 'method' => 'GET', 'class' => 'form-horizontal']) }}
                                                                    {{ Form::hidden('type', config('word.filter.ulearn'), ['class' => 'form-control']) }}
                                                                    {{ Form::hidden('page', $page, ['class' => 'form-control']) }}
                                                                    {{ Form::button(trans('homepage.unlearned_word'), ['type' => 'submit', 'class' => 'btn btn-danger  btn-filter']) }}
                                                                {{ Form::close() }}
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{ Form::open(['url' => '/home', 'method' => 'GET', 'class' => 'form-horizontal']) }}
                                                                    {{ Form::hidden('type', config('word.filter.learned'), ['class' => 'form-control']) }}
                                                                    {{ Form::hidden('page', $page, ['class' => 'form-control']) }}
                                                                    {{ Form::button(trans('homepage.learned_word'), ['type' => 'submit', 'class' => 'btn btn-warning']) }}
                                                                {{ Form::close() }}
                                                            </div>
                                                            <div class="col-md-2">
                                                                {{ Form::open(['url' => '/home', 'method' => 'GET', 'class' => 'form-horizontal']) }}
                                                                    {{ Form::hidden('type', config('word.filter.all'), ['class' => 'form-control']) }}
                                                                    {{ Form::hidden('page', $page, ['class' => 'form-control']) }}
                                                                    {{ Form::button(trans('homepage.word_all'), ['type' => 'submit', 'class' => 'btn btn-default  btn-filter']) }}
                                                                {{ Form::close() }}
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="col-md-12">
                                                            <div class="col-md-6">
                                                                {{ Form::open(['url' => '/home', 'method' => 'GET', 'class' => 'form-horizontal', 'id' => 'category-filter']) }}
                                                                    {{ Form::hidden('type', config('word.filter.category'), ['class' => 'form-control']) }}
                                                                    {{ Form::hidden('page', $page, ['class' => 'form-control']) }}
                                                                    {{ Form::select('category', $categories, null, ['class' => 'form-control' ]) }}
                                                                {{ Form::close() }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h1>{{ trans('homepage.type.' . $type) }}</h1>
                                                    <div class="table-container">
                                                        <table class="table table-filter display" id="table-filter">
                                                            <tbody>
                                                            @foreach ($filterResults as $key => $filterResult)
                                                                <tr data-status="{{ $type }}">
                                                                    <td>
                                                                        <a href="javascript:;" class="star">
                                                                            <i class="glyphicon glyphicon-star"></i>
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        <div class="media col-md-12">
                                                                            <div class="col-md-3">
                                                                                <a href="#" class="{{ $type }}">
                                                                                    @if ($type == config('word.filter.ulearn') || $type == config('word.filter.learned'))
                                                                                        {{ $filterResult->word->content }}
                                                                                    @else
                                                                                        {{ $filterResult->content }}
                                                                                    @endif
                                                                                </a>
                                                                            </div>
                                                                            <div class="media-body">
                                                                                <span class="media-meta pull-right"></span>
                                                                                <h4 class="title text-justify">
                                                                                    <i>
                                                                                        @if ($type == config('word.filter.ulearn') || $type == config('word.filter.learned'))
                                                                                            {{ $filterResult->content }}
                                                                                        @else
                                                                                            @foreach ($filterResult->answers as $key => $answer)
                                                                                                @if ($answer->isCorrect())
                                                                                                    {{ $answer->content }}
                                                                                                @endif
                                                                                            @endforeach()
                                                                                        @endif
                                                                                    </i>
                                                                                    <span class="pull-right pagado">{{ $type }}</span>
                                                                                </h4>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                @endforeach()
                                                            </tbody>
                                                        </table>
                                                        {!! $filterResults->appends(array_except(Request::query(), 'wordlist_page', 'page'))->render() !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End home content-->
                    <div class="fix home-content-sidebar floatright">
                        <div class="home-single-sidebar">
                            <h2><i class="fa fa-bars"></i> {{ trans('homepage.category_menu') }}</h2>
                            {{ Form::open(['url' => '/home', 'method' => 'GET', 'class' => 'form-horizontal', 'id' => 'category-menu']) }}
                                {{ Form::hidden('lessonType', config('word.filter.category_lesson'), ['class' => 'form-control']) }}
                                {{ Form::hidden('page', $page, ['class' => 'form-control']) }}
                                {{ Form::select('category', $categories, null, ['class' => 'form-control']) }}
                            {{ Form::close() }}
                        </div>
                    </div> <!-- End home sidebar-->
                </div>
            </div> <!-- End main content-->
        </div>
    </div>
</div>
@endsection

@section('js')
    {!! Html::script('js/wordlist.js') !!}
@endsection
