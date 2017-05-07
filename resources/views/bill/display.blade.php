@extends('layouts.layout');

@section('content')
    <div id="mainApp">
        <app-main page-title="Contract Bill">
            <bill-readable bill-no="{{$billNo}}"></bill-readable>
        </app-main>
    </div>
@endsection



