@extends('layouts.app')

@section('content')

    <div class="container center-align white paddind_bot z-depth-2">
        <h5 class="h3 margin_top_l padding_top">Reset Password</h5>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form class="" role="form" method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="  container">

                    <div class="row">
                        <div class="input-field {{ $errors->has('email') ? ' has-error' : '' }}">
                            <input placeholder=" " id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                                   required autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                            <label for="email">E-Mail Address</label>
                        </div>
                    </div>

                    <br>

                    <button type="submit" class="btn grey white-text ">
                        Send Password Reset Link
                    </button>
                </div>
            </div>
        </form>

    </div>


@endsection
