@extends("layouts.layout")

@section("content")

<div id="mainApp">
    <app-main page-title="Villa">
        <villa-list url="{!! url('villa/register')!!}"></villa-list>
    </app-main>
</div>

@endsection


