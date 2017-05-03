<template>

  <form id="ConTenantForm" class="form-horizontal" @submit.prevent="contract.save()" @keydown="errors.clear($event.target.name)">
        <div class="col-md-6">
          <div class="panel panel-info">
            <div class="panel-heading ">
              <center><i class="fa fa-address-book-o fa-lg" aria-hidden="true"></i> TENANT REGISTRATION </center>
            </div>
            <div class="panel-body">
                <div>
                  <div class='form-group'>
                    <label for='tenant_type' class='col-md-3'>Tenant Type</label>
                    <div class='col-md-9'>
                      <select class='form-control' name='tenant_type' v-model='contract.data.register_tenant.type'  @change="selectTenant" id='tenant_type'>
                        <option v-for='lookup in contract.lookups.tenant_type' v-bind:value='lookup.code'>{{lookup.name}}</option>
                      </select>
                    </div>
                  </div>
                  
                   <div class='form-group'>
                    <label for='reg_name' class='col-md-3'>{{contract.label.fullName}}</label>
                    <div class='col-md-9'>
                      <input type='text' class='form-control' name='full_name' v-model='contract.data.register_tenant.full_name' id='full_name'>
                      <strong class="text-danger text-small" v-text="contract.errors.get('full_name')"></strong>
                    </div>
                  </div>

                  <div class='form-group'>
                    <label for='reg_name' class='col-md-3'>{{contract.label.regName}}</label>
                    <div class='col-md-9'>
                      <input type='text' class='form-control' name='reg_name' v-model='contract.data.register_tenant.reg_name' id='reg_name'>
                      <strong class="text-danger text-small" v-text="contract.errors.get('full_name')"></strong>
                    </div>
                  </div>

                  <div class='form-group'>
                    <label for='reg_id' class='col-md-3'>{{contract.label.regNo}}</label>
                    <div class='col-md-9'>
                      <input type='text' class='form-control' name='reg_name' v-model='contract.data.register_tenant.reg_id' id='reg_id'>
                      <strong class="text-danger text-small" v-text="contract.errors.get('reg_id')"></strong>
                    </div>
                  </div>

                <div class="form-group">
                  <label class="col-md-3" >{{contract.label.regDate}}</label>
                  <div class="col-md-9">
                    <div class='input-group date' id='datetimepicker1'>
                      <input type='text' class="form-control" v-model="contract.data.register_tenant.reg_date" />
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                
                <div class="form-group" v-if="contract.isShowBirthday()" >
                  <label class="col-md-3" >Gender:</label>
                  <div class="col-md-9">
                    <select class="form-control" name="gender" v-model="contract.data.register_tenant.gender" >
                      <option value="male">MALE</option>
                      <option value="female">FEMALE</option>
                    </select>
                  </div>
                </div>

                <hr/>

                <div class="form-group">
                  <label class="col-md-3">Email Address:</label>
                  <div class="col-md-9">
                    <input name="email_address" type="text" class="form-control" v-model="contract.data.register_tenant.email_address">
                  </div>
                </div>

                <div class="form-group">
                  <label  class="col-md-3" >Tel No:</label>
                  <div class="col-md-9">
                    <input name="tel_no" type="text" class="form-control" v-model="contract.data.register_tenant.tel_no">
                  </div>
                </div>

                <div class="form-group">
                  <label  class="col-md-3">Mobile No:</label>
                  <div class="col-md-9">
                    <input name="mobile_no" type="text" class="form-control" v-model="contract.data.register_tenant.mobile_no">
                  </div>
                </div>
                
                <div class="form-group">
                  <label  class="col-md-3">Fax No:</label>
                  <div class="col-md-9">
                    <input name="fax_no" type="text" class="form-control" v-model="contract.data.register_tenant.fax_no">
                  </div>
                </div>
                <hr/>

                <div class="form-group">
                  <label  class="col-md-3" >Address 1:</label>
                  <div class="col-md-9">
                    <input name="address_1" type="text" class="form-control"  v-model="contract.data.register_tenant.address_instance.address_1">
                  </div>
                </div>

                <div class="form-group">
                  <label  class="col-md-3" >Address 2:</label>
                  <div class="col-md-9">
                    <input name="address_2" type="text" class="form-control" v-model="contract.data.register_tenant.address_instance.address_2">
                  </div>
                </div>
               
                <div class="form-group">
                  <label  class="col-md-3" >City:</label>
                  <div class="col-md-3">
                    <input name="city" type="text" class="form-control" v-model="contract.data.register_tenant.address_instance.city">
                  </div>

                   <label  class="col-md-3" >Postal Code:</label>
                   <div class="col-md-3">
                    <input name="postal_code" type="text" class="form-control" v-model="contract.data.register_tenant.address_instance.postal_code">
                  </div>
                </div>
                </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <contractvilla :contract="contract"></contractvilla>
          <contractcreate :contract="contract"> </contractcreate>
        </div>
  </form>

</template>


<script>

import ContractCreate from './ContractCreate.vue';
import ContractVilla from './ContractVilla.vue';
let contractRegister = require('./ContractRegisterModel.js');

export default {
    name: "ConTenantForm",
    components: {'contractvilla': ContractVilla, 'contractcreate': ContractCreate },

    data()  {
        return {
            btnSave: false,
            contract: contractRegister.default.createInstance()
        }
    },
 methods: {
   onSave() {
        var $this = this;
        var formData = new FormData();
   },
   selectTenant() {
      this.contract.onTenantTypeChange();
   }
 },
 created: function () {
   this.contract.create()
 },
 computed: {
   isIndividual(){
     return this.contract.isIndividual()
   },
   isCompany(){
     return this.contract.isCompany()
   }
 }

}

</script>
