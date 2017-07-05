@extends('layouts.app')

@section('content')

    <div id="login">
        @if ($errors->has('email'))
            <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
        @endif
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
    <form role="form" method="POST" action="{{ route('login') }}" class="login">
        {{ csrf_field() }}
        <fieldset class="clearfix">
            <p><span class="fontawesome-user"></span><input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus></p>

            <p><span class="fontawesome-lock"></span><input id="password" type="password" class="form-control" name="password" required></p>

            <p><input type="submit" value="Log in"></p>
        </fieldset>
    </form>
    </div>>

@endsection
