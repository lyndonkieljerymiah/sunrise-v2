@extends("layouts.layout")
@section("content")
<div id="mainApp">
    <app-main page-title="CONTRACT">
      <contract-view url="{!! url('contract/create')!!}"></contract-view>
    </app-main>
</div>
@endsection
