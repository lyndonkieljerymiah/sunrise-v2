@extends('layouts.layout')

@section('content')
<div id="mainApp">
    <app-main page-title="Contract Bill">
        <contract-bill contract-id="{{$contractId}}"></contract-bill>
    </app-main>
</div>
@endsection

