<template>

<div id="ConCreate">
    <div class="panel panel-primary">
      <div class="panel-body">


      <div class='form-group'>
        <label for='tenant_type' class='col-md-3'>Contract Type:</label>
        <div class='col-md-9'>
          <select class="form-control">
              <option v-for="lookup in contract.lookups.contract_type"
                  v-bind:value="lookup.code" >{{lookup.name}}</option>
          </select>
        </div>
      </div>


      <div class='form-group'>
        <label for='tenant_type' class='col-md-3'>Period Start:</label>
        <div class='col-md-9'>
          <div class='input-group date' id='datetimepicker3'>
            <input type='text' class="form-control" name="period_start" v-bind:value='contract.data.period_start'>
            <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </span>
          </div>
        </div>
      </div>



      <div class='form-group'>
        <label for='tenant_type' class='col-md-3'>Periord End:</label>
        <div class='col-md-9'>
          <div class='input-group date' id='datetimepicker3'>
            <input type='text' class="form-control" name="period_end" v-bind:value='contract.data.period_end'>
            <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </span>
          </div>
        </div>
      </div>

      <div class='form-group'>
        <label for='tenant_type' class='col-md-3'>Amount:</label>
        <div class='col-md-9'>
          <div class='input-group'>
            <input name="contract_no" type="text" class="form-control" placeholder="AMOUNT *">
            <span class="input-group-addon">
              QAR
            </span>
          </div>
        </div>
      </div>


        <div class="col-md-12">
          <button type="submit" class="btn-sm btn-primary pull-right">CALCULATE</button>
        </div>
      </div>
    </div>

  <div class="panel panel-primary">
    <div class="panel-body" style="padding-left:0px; padding-right:0px;">
      <div class="col-md-12">
        <div class="col-md-12">
          <button type="submit" class="btn-sm btn-primary pull-right">SAVE</button>
        </div>
      </div>
    </div>
  </div>


</div>

</template>
<script>
export default {
  name: "ConCreate",
  props:["contract"]
}



</script>
