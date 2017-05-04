<template>
  <div id="ConCreate">


    <div class="panel panel-primary">
      <div class="panel-body">


      <div class='form-group'>
        <label for='tenant_type' class='col-md-3'>Contract Type:</label>
        <div class='col-md-9'>
          <select class="form-control">
              <option v-for="lookup in contract.lookups.contract_type"
                  v-model:value="lookup.code" >{{lookup.name}}</option>
          </select>

        </div>
      </div>


      <div class='form-group'>
        <label for='tenant_type' class='col-md-3'>Period Start:</label>
        <div class='col-md-9'>
          <div class='input-group date' id='datetimepicker3'>
            <input type='text' class="form-control" name="period_start" v-model:value='contract.data.period_start'>
            <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </span>
          </div>
            <error :errorDisplay="contract.errors.get('period_start')">{{ contract.errors.get('period_start') }}</error>
        </div>
      </div>



      <div class='form-group'>
        <label for='tenant_type' class='col-md-3'>Periord End:</label>
        <div class='col-md-9'>
          <div class='input-group date' id='datetimepicker3'>
            <input type='text' class="form-control" name="period_end" v-model:value='contract.data.period_end'>
            <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </span>
          </div>
          <error :errorDisplay="contract.errors.get('period_end')">{{ contract.errors.get('period_end') }}</error>
        </div>
      </div>

      <div class='form-group'>
        <label for='tenant_type' class='col-md-3'>Amount:</label>
        <div class='col-md-9'>
          <div class='input-group'>
            <input name="amount" type="text" class="form-control" placeholder="AMOUNT *" v-model='contract.data.amount'>
            <span class="input-group-btn">
              <button class="btn btn-secondary" type="button"  @click="contract.recal()"><i class="fa fa-calculator" aria-hidden="true"></i></button>
            </span>
          </div>
          <error :errorDisplay="contract.errors.get('amount')">{{ contract.errors.get('amount') }}</error>
        </div>
      </div>


        <div class="col-md-12">

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
</div>
</template>
<script>

import ErrorLabel from '../ErrorLabel.vue';

export default {
  name: "ConCreate",
  props:["contract"],

  components: {
    'error': ErrorLabel
  },

  methods: {
     calc() {
       this.contract.recal()


     }
  }

}



</script>
