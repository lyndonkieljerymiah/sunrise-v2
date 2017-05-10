<template>
  <div id="ConCreate" class="row">


    <div class="panel panel-primary">
      <div class="panel-body">


      <div class='form-group'>
        <label for='tenant_type' class='col-md-3'>Contract Type:</label>
        <div class='col-md-9'>
          <select class="form-control" v-model="contract.data.contract_type">
              <option v-for="lookup in contract.lookups.contract_type"
                  :value="lookup.code" >{{lookup.name}}</option>
          </select>
        </div>
      </div>


      <div class='form-group'>
        <label for='tenant_type' class='col-md-3'>Period Start:</label>
        <div class='col-md-9'>
          <dtpicker dp-name="period_start" @pick="changeDate" :value="contract.data.period_start"></dtpicker>
            <error :errorDisplay="contract.errors.get('period_start')">{{ contract.errors.get('period_start') }}</error>
        </div>
      </div>



      <div class='form-group'>
        <label for='tenant_type' class='col-md-3'>Periord End:</label>
        <div class='col-md-9'>
            <dtpicker dp-name="period_end" @pick="changeDate" :value="contract.data.period_end"></dtpicker>
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


      </div>
    </div>

  <div class="panel panel-primary">
    <div class="panel-body">
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

import ErrorLabel from '../ErrorLabel.vue';
import DateTimePicker from '../DateTimePicker.vue';

export default {
  name: "ConCreate",
  props:["contract"],

  components: {
    'error': ErrorLabel,
    'dtpicker': DateTimePicker
  },

  methods: {
     calc() {
       this.contract.recal()


     },
     changeDate(name, d) {
       this.contract.changeDate(name, d);
     }
  }

}



</script>
