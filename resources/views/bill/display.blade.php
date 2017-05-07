@extends('layouts.layout');

@section('content')
    <div id="mainApp">
        <app-main page-title="Contract Bill">
            <bill-readable :main-data="{{$bill}}"></bill-readable>
        </app-main>
    </div>
@endsection



