@extends('layouts.app')

@section('css')
    {!! Html::style('css/wordlist.css') !!}
    {!! Html::style('//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css') !!}
@endsection()

@section('content')
<div class="container">
    <div class="row">
        <div class="text-center">
            <div class="fix main_content_area">
                <div class="fix centre main_content">
                    <div class="fix home_content floatleft">
                        <div class="fix single_home_content">
                            <div class="fix single_home_content_container">
                                <h2><i class="fa fa-angle-double-down"></i> {{ trans('homepage.title_lesson') }} </h2>
                                @foreach ($lessons as $key => $lesson)

                                <div class="fix single_content floatleft">
                                    <img src="http://www.lawnsciencesouthmanchester.co.uk/images/blog/weeds/Daisy_flower.jpg"/>
                                    <h2>{{ $lesson->name }} </h2>
                                </div>
                                @endforeach
                            </div>
                            {!! $lessons->appends(array_except(Request::query(), 'wordlist_page', 'page'))->render() !!}
                        </div>

                        <div class="fix single_home_blog_content">
                            <div class="fix single_blog_content_container">
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
                                                                    {{ Form::hidden('type', 'new', ['class' => 'form-control']) }}
                                                                    {{ Form::hidden('page', $page, ['class' => 'form-control']) }}
                                                                    {{ Form::button(trans('homepage.new_word'), ['type' => 'submit', 'class' => 'btn btn-success']) }}
                                                                {{ Form::close() }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                {{ Form::open(['url' => '/home', 'method' => 'GET', 'class' => 'form-horizontal']) }}
                                                                    {{ Form::hidden('type', 'ulearn', ['class' => 'form-control']) }}
                                                                    {{ Form::hidden('page', $page, ['class' => 'form-control']) }}
                                                                    {{ Form::button(trans('homepage.unlearned_word'), ['type' => 'submit', 'class' => 'btn btn-danger  btn-filter']) }}
                                                                {{ Form::close() }}
                                                            </div>
                                                            <div class="col-md-3">
                                                                {{ Form::open(['url' => '/home', 'method' => 'GET', 'class' => 'form-horizontal']) }}
                                                                    {{ Form::hidden('type', 'learned', ['class' => 'form-control']) }}
                                                                    {{ Form::hidden('page', $page, ['class' => 'form-control']) }}
                                                                    {{ Form::button(trans('homepage.learned_word'), ['type' => 'submit', 'class' => 'btn btn-warning']) }}
                                                                {{ Form::close() }}
                                                            </div>
                                                            <div class="col-md-2">
                                                                {{ Form::open(['url' => '/home', 'method' => 'GET', 'class' => 'form-horizontal']) }}
                                                                    {{ Form::hidden('type', 'all', ['class' => 'form-control']) }}
                                                                    {{ Form::hidden('page', $page, ['class' => 'form-control']) }}
                                                                    {{ Form::button(trans('homepage.word_all'), ['type' => 'submit', 'class' => 'btn btn-default  btn-filter']) }}
                                                                {{ Form::close() }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h1>{{ trans('homepage.type.' . $type) }}</h1>
                                                    <div class="table-container">
                                                        <table class="table table-filter display" id="table-filter">
                                                            <tbody>
                                                            @foreach ($words as $key => $word)
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
                                                                                    {{ $word->word->content }}
                                                                                </a>
                                                                            </div>
                                                                            <div class="media-body">
                                                                                <span class="media-meta pull-right"></span>
                                                                                <h4 class="title text-justify">
                                                                                    <i>
                                                                                        {{ $word->content }}
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
                                                        {!! $words->appends(array_except(Request::query(), 'wordlist_page', 'page'))->render() !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End home content-->
                    <div class="fix home_content_sidebar floatright">
                        <div class="home_single_sidebar">
                            <h2><i class="fa fa-bars"></i> {{ trans('homepage.category_menu') }}</h2>
                            <select class="form-control">
                                <option selected="selected"><a>{{ trans('homepage.select_category') }}</a></option>
                                @foreach ($categories as $key => $category)
                                    <option><a>{{ $category->name }}</a></option>
                                @endforeach()
                            </select>
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
