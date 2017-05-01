
@extends("layouts.layout")

@section("content")
<div id="mainApp">
    <app-main page-title="New Villa">
        <villa-form 
            form-action="{{ (isset($id) && $id!=0) ? 'edit/'.$id : 'create' }}" 
            operation-type="{{ (isset($id) && $id!=0) ? 'update' : 'store' }}">
        </villa-form>
    </app-main>
</div>
@endsection
