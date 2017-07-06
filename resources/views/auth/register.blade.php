@extends('layouts.app')

@section('content')

    <div id="login">
        @if ($errors->has('name'))
            <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
        @endif
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
        <form role="form" method="POST" action="{{ route('register') }}" class="login">
            {{ csrf_field() }}
            <fieldset class="clearfix">
                <p><span class="fontawesome-user"></span><input placeholder="name" id="name" type="text" class="form-control" name="name"
                                                                value="{{ old('name') }}" required autofocus></p>
                <p><span class="zocial-email"></span><input placeholder="email" id="email" type="email" class="form-control" name="email"
                                                            value="{{ old('email') }}" required></p>

                <p><span class="fontawesome-lock"></span><input placeholder="password" id="password" type="password" class="form-control"
                                                                name="password" required></p>

                <p><span class="fontawesome-lock"></span><input placeholder="password-confirm" id="password-confirm" type="password"
                                                                class="form-control" name="password_confirmation"
                                                                required></p>
                <p><input type="submit" value="Register"></p>
            </fieldset>
        </form>
    </div>

@endsection


