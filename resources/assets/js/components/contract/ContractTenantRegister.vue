<template>
  <div id="ConTenantForm">

        <div class="col-md-5">
          <div class="panel panel-primary">
            <div class="panel-heading "><center><i class="fa fa-address-book-o fa-lg" aria-hidden="true"></i> TENANT REGISTRATION </center></div>
            <div class="panel-body" style="padding-left:0px; padding-right:0px;">


              <div class="col-md-6">
                  <label  class="col-md-12">SELECT *</label>
                <select name="tenant_type" class="form-control" v-model="tenant.type">
                    <option v-for="lookup in lookups.tenant_type"
                        v-bind:value="lookup.code" >{{lookup.name}}</option>
                </select>
              </div>

              <div class="col-md-6">
                <label v-if="tenant.type == 'company'" class="col-md-12" >Representative *</label>
                <label v-else="tenant.type == 'individual'" class="col-md-12" >Company*</label>
              <input name="telno" type="text" class="form-control">
              </div>

              <div class="col-md-6">
                <br/>
                <label v-if="tenant.type == 'company'" class="col-md-12" >BUSSINESS *</label>
                <label v-else="tenant.type == 'individual'" class="col-md-12" >FULL NAME *</label>
                <input name="full_name" type="text" class="form-control">
              </div>



              <div class="col-md-6" v-if="tenant.type == 'company'" >
              <br/>
                <label class="col-md-12" >Validity Date. *</label>
                <div class="form-group">
                  <div class='input-group date' id='datetimepicker1'>
                    <input type='date' class="form-control" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
              </div>
              </div>
              <div class="col-md-6" v-else="tenant.type == 'individual'" >
                <br/>
                <label  class="col-md-12">Birth Date *</label>
                <div class="form-group">
                  <div class='input-group date' id='datetimepicker1'>
                    <input type='date' class="form-control" name="bday" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
              </div>
              </div>



              <div class="col-md-6" v-if="tenant.type == 'company'" >
                <label class="col-md-12" >Bussiness Type. *</label>
                <input name="Bussiness" type="text" class="form-control">
              </div>

              <div class="col-md-6" v-else="tenant.type == 'individual'" >
                <label class="col-md-12" >Gender *</label>
                <select class="form-control" name="gender">
                  <option value="1">MALE</option>
                  <option value="2">FEMALE</option>
                </select>
              </div>



              <div class="col-md-6">
                <label class="col-md-12">Email Address *</label>
                <input name="emailadd" type="text" class="form-control">
              </div>



              <div class="col-md-6" v-if="tenant.type == 'company'">
                <br/>
                <label  class="col-md-12">CR No. *</label>
                <input name="cr_no" type="text" class="form-control">
              </div>
              <div class="col-md-6" v-else="tenant.type == 'individual'">
                <br/>
                <label  class="col-md-12">QATAR ID. *</label>
                <input name="qarid" type="text" class="form-control">
              </div>



              <div class="col-md-6">
                <br/>
                <label  class="col-md-12" >Fax No *</label>
                <input name="faxno" type="text" class="form-control">
              </div>
              <div class="col-md-6">
                <br/>
                <label v-if="tenant.type == 'company'" class="col-md-12" >Validity Date *</label>
                <label v-else="tenant.type == 'individual'" class="col-md-12" >Registration Date *</label>
                <div class="form-group">
                  <div class='input-group date' id='datetimepicker1'>
                    <input type='date' class="form-control" name="regdate" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <br/>
              <label  class="col-md-12">Mobile No. *</label>
              <input name="mobileno" type="text" class="form-control">
            </div>


            <div class="col-md-6">
              <br/>
            </div>
            <div class="col-md-6">
                <label  class="col-md-12">Tel No *</label>
              <input name="telno" type="text" class="form-control">
            </div>


            <div class="col-md-12">
              <br/>
              <label  class="col-md-12" >Address 1 *</label>
              <input name="address1" type="text" class="form-control">
            </div>
            <div class="col-md-12">
              <br/>
              <label  class="col-md-12" >Address 2 *</label>
              <input name="address2" type="text" class="form-control">
            </div>
            <div class="col-md-6">
              <br/>
              <label  class="col-md-12" >City *</label>
              <input name="city" type="text" class="form-control" >
            </div>
            <div class="col-md-6">
                    <br/>
              <label  class="col-md-12" >Postal Code *</label>
              <input name="postalcode" type="text" class="form-control" >
            </div>

            </div>
          </div>


      </div>

      <contractvilla :villas="villas"></contractvilla>
        <contractcreate :contract="contract"></contractcreate>

    </div>

</template>


<script>

import ContractCreate from './ContractCreate';
import ContractVilla from './ContractVilla.vue';

export default {
  name: "ConTenantForm",
  components: {'contractvilla': ContractVilla, 'contractcreate': ContractCreate },
  data()  {
    return {
    contract:{},
    villas:{},
    tenant:{},
    lookups:{},
    selected:''
   }
 },
 created: function () {
   var $this = this;
   AjaxRequest.get('contract', 'create').then(function (r){
    $this.villas=r.data.villas;
    $this.lookups=r.data.lookups;
    $this.tenant=r.data.tenant;
   });
 }
}

</script>
