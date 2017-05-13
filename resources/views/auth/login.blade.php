@extends('layouts.login')

@section('content')
<!-- Modal -->
<div id="loginAdminModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="inner-container">
            <div class="box-vid">
                <button type="button"  class="close" style="width:5px;margin-right:20px;margin-top:-10px;" data-dismiss="modal">&times;</button>
                <h1>Admin Login</h1>
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
