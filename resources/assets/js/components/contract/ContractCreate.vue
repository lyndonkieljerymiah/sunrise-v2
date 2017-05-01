<template>
<div id="ConCreate">
  <div class="col-md-7">
    <div class="panel panel-primary">
      <div class="panel-body" style="padding-left:0px; padding-right:0px;">
        <div class="col-md-4">
          <select name="location" class="form-control">
              <option v-for="lookup in lookups.contract_type"
                  v-bind:value="lookup.code" >{{lookup.name}}</option>
          </select>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <div class='input-group date' id='datetimepicker3'>
              <input type='date' class="form-control" placeholder="YYYY-MM-DD(START DATE)" name="period_start">
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </div>


        <div class="col-md-4">
          <div class="form-group">
            <div class='input-group date' id='datetimepicker3'>
              <input type='date' class="form-control" placeholder="YYYY-MM-DD(END DATE)" name="period_end">
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </div>


        <div class="col-md-4">
          <input name="contract_no" type="text" class="form-control " placeholder="CONTRACT NUMBER *">
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <div class='input-group'>
              <input name="contract_no" type="text" class="form-control" placeholder="AMOUNT *">
              <span class="input-group-addon">
                QAR
              </span>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <button type="submit" class="btn-sm btn-primary">CALCULATE</button>
        </div>


      </div>
    </div>


  <div class="panel panel-primary">
    <div class="panel-body" style="padding-left:0px; padding-right:0px;">
      <div class="col-md-12">


        <div class="col-md-12">
          <button type="submit" class="btn-sm btn-primary">SAVE</button>
          <button type="button" class="btn-sm btn-warning">CANCEL</button>
          <button type="button" class="btn-sm btn-primary pull-right">EDIT VILLA</button>
        </div>


      </div>
    </div>
  </div>


  </div>
</div>
</template>
<script>


export default {
  name: "ConCreate",

  data()  {
    return {
    lookups:{},

   }
 }
}
</script>
