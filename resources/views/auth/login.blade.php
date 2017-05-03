@extends('layouts.login')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login">
                <div class="login-title">Login</div>
                <form method="POST" action="{{ route('login') }}">
                    <div class="login-fields">
                        {{ csrf_field() }}
                        <input id="username" type="text" name="username" placeholder="Enter User" value="{{ old('username') }}" required autofocus autocomplete="off">
                        @if ($errors->has('email'))
                            <span class="icon"  data-toggle="tooltip" data-placement="right" title="{{$errors->first('username')}}">
                               <i class="fa fa-warning fa-2x"></i>
                            </span>
                        @endif
                        <input id="password" type="password" placeholder="Enter Password" name="password" required autocomplete="off">
                        @if ($errors->has('password'))
                            <span class="icon"  data-toggle="tooltip" data-placement="right" title="{{$errors->first('password')}}">
                                 <i class="fa fa-warning fa-2x"></i>
                            </span>
                        @endif
                    </div>
                    <div class="login-submit">
                        <button type="submit">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
