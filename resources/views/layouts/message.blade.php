<div class="col-lg-8 col-lg-offset-2">
    @if ($errors->count())
        <div class="alert alert-danger">
            <p><strong>{{ trans('homepage.error_title') }}</strong></p>
            <ul>
                @foreach ($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->has('message'))
        <div class="alert alert-warning">
            <ul>
                {{ session('message') }}
            </ul>
        </div>
    @endif
    @if (session()->has('success'))
        <div class="alert alert-success">
            <ul>
                {{ session('success') }}
            </ul>
        </div>
    @endif
</div>
