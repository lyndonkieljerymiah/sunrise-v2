
@extends("layouts.layout")

@section("content")
<div id="mainApp" class="container-page">
    <div class="page-header">
        <h3>
            @if($id == 0) 
                Create Villa
            @else 
                Update Villa
            @endif
        </h3>
    </div>
    <form id="frmVillaEntry" method="POST" action="javascript:;"  class="form-horizontal">
        <div class="form-group">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="location" class="col-md-2 text-right">Location:</label>
                    <div class="col-md-10">
                        <select v-model="model.location" class="form-control">
                            <option v-for="lookup in lookups.villa_location" 
                                v-bind:value="lookup.code" >@{{lookup.name}}</option>
                        </select>
                    </div>
                </div>

                <div class="form-group ">
                    <label for="villa_no" class="col-md-2 text-right">Villa No:</label>
                    <div class="col-md-10">
                        <input name="villa_no" type="text" class="form-control" v-model="model.villa_no" > 
                    </div>
                </div>

                <div class="form-group">
                    <label for="description" class="col-md-2 text-right">Description:</label>
                    <div class="col-md-10">
                        <textarea name="description" rows="5" class="form-control" v-model="model.description"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="electricity_no" class="col-md-2 text-right">Electrity No:</label>
                    <div class="col-md-4">
                        <input name="electricity_no" type="text" class="form-control" v-model="model.electricity_no">
                    </div>

                    <label for="water_no" class="col-md-2 text-right">Water No:</label>
                    <div class="col-md-4">
                        <input name="water_no" type="text" class="form-control" v-model="model.water_no">
                    </div>
                </div>

                <div class="form-group">
                    <label for="qtel_no" class="col-md-2 text-right">QTel No:</label>
                    <div class="col-md-4">
                        <input name="qtel_no" type="text" class="form-control" v-model="model.qtel_no">
                    </div>

                    <label for="capacity" class="col-md-2 text-right" >Capacity:</label>
                    <div class="col-md-4">
                        <input name="capacity" type="number" class="form-control" v-model="model.capacity">
                    </div>
                </div>

                <div class="form-group">

                    <label for="rate_per_month" class="col-md-2 text-right">Rate per Month:</label>
                    <div class="col-md-4">
                        <input name="rate_per_month" type="text" class="form-control" v-model="model.rate_per_month">
                    </div>

                    <label for="villa_class" class="col-md-2 text-right">Villa Class:</label>
                    <div class="col-md-4">
                         <select v-model="model.villa_class" class="form-control">
                            <option v-for="lookup in lookups.villa_type" v-bind:value="lookup.code">@{{lookup.name}}</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Description</th>
                                <th>Size</th>
                                <th style="width:10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="">
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="form-group">
                    <button class="btn btn-info pull-right" :disabled="btnDisabled"  v-on:click="onSave">Save</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <button class="btn btn-info btn-block">Upload</button>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    
</script>
@endsection