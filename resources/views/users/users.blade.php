@extends("layouts.layout")
@section("content")
<div id="mainApp">
    <app-main page-title="USER'S ACCOUNT">
      <users-list url="{!! url('users/userslist')!!}"></users-list>
    </app-main>
</div>
@endsection
