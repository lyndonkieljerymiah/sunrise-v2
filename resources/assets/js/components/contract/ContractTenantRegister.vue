<template>
<form id="ConTenantForm" class="form-horizontal" @submit.prevent="contract.save()" @keydown="contract.errors.clear($event.target.name)">
    <div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <i class="fa fa-address-book-o fa-lg" aria-hidden="true"></i> TENANT REGISTRATION
            </div>
            <div class="panel-body">
                <div class='form-group'>
                    <label class='col-md-3'>Tenant Type</label>
                    <div class='col-md-9'>
                        <select class='form-control' name='register_tenant.type' v-model='contract.data.register_tenant.type'  @change="selectTenant">
                        <option v-for='lookup in contract.lookups.tenant_type' v-bind:value='lookup.code'>{{lookup.name}}</option>
                        </select>
                    </div>
                </div>

                <div class='form-group'>
                    <label class='col-md-3'>{{contract.label.fullName}}</label>
                    <div class='col-md-9'>
                        <input type='text' class='form-control' name='register_tenant.full_name' v-model='contract.data.register_tenant.full_name'>
                        <error :errorDisplay="contract.errors.get('register_tenant.full_name')">{{contract.errors.get('register_tenant.full_name')}}</error>
                    </div>
                </div>

                <!-- Company / Representative -->
                <div class='form-group'>
                    <label for='reg_name' class='col-md-3'>{{contract.label.regName}}</label>
                    <div class='col-md-9'>
                        <input type='text' class='form-control' name='register_tenant.reg_name' v-model='contract.data.register_tenant.reg_name' id='reg_name'>
                    </div>
                </div>

                <!-- Qatar Id / CR No -->
                <div class='form-group'>
                    <label for='reg_id' class='col-md-3'>{{contract.label.regNo}}</label>
                    <div class='col-md-9'>
                        <input type='text' class='form-control' name='register_tenant.reg_id' v-model='contract.data.register_tenant.reg_id'>
                        <error :errorDisplay="contract.errors.get('register_tenant.reg_id')">{{contract.errors.get('register_tenant.reg_id')}}</error>
                    </div>
                </div>

                <!-- Birthday / Validity Date -->
                <div class="form-group">
                    <label class="col-md-3" >{{contract.label.regDate}}</label>

                    <div class="col-md-9">
                        <dtpicker dp-name="register_tenant.reg_date" @pick="changeDate" :value="contract.data.register_tenant.reg_date"></dtpicker>
                        <error :errorDisplay="contract.errors.get('register_tenant.reg_date')">{{contract.errors.get('register_tenant.reg_date')}}</error>
                    </div>
                </div>

                <div class="form-group" v-show="contract.isShowBirthday()" >
                    <label class="col-md-3" >Gender:</label>
                    <div class="col-md-9">
                        <select class="form-control" name="gender" v-model="contract.data.register_tenant.gender" >
                            <option value="Male" selected="true">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>
                <hr/>

                <div class="form-group">
                    <label class="col-md-3">Email Address:</label>
                    <div class="col-md-9">
                        <input name="register_tenant.email_address" type="text" class="form-control" v-model="contract.data.register_tenant.email_address">
                        <error :errorDisplay="contract.errors.get('register_tenant.email_address')">{{contract.errors.get('register_tenant.email_address')}}</error>
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
                        <input name="register_tenant.mobile_no" type="text" class="form-control" v-model="contract.data.register_tenant.mobile_no">
                        <error :errorDisplay="contract.errors.get('register_tenant.mobile_no')">{{contract.errors.get('register_tenant.mobile_no')}}</error>
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
                    <label class="col-md-3" >Address 1:</label>
                    <div class="col-md-9">
                        <input name="register_tenant.address_instance.address_1"
                        type="text" class="form-control"  v-model="contract.data.register_tenant.address_instance.address_1">
                        <error :errorDisplay="contract.errors.get('register_tenant.address_1')">{{contract.errors.get('register_tenant.address_1')}}</error>
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
                        <input name="register_tenant.address_instance.city" id="register_tenant.address_instance.city" type="text" class="form-control" v-model="contract.data.register_tenant.address_instance.city">
                        <error :errorDisplay="contract.errors.get('register_tenant.address_instance.city')">{{contract.errors.get('register_tenant.address_instance.city')}}</error>
                    </div>

                    <label  class="col-md-3" >Postal Code:</label>
                    <div class="col-md-3">
                        <input name="register_tenant.address_instance.postal_code" id="register_tenant.address_instance.postal_code" type="text" class="form-control"
                        v-model="contract.data.register_tenant.address_instance.postal_code">
                        <error :errorDisplay="contract.errors.get('register_tenant.address_instance.postal_code')">{{contract.errors.get('register_tenant.address_instance.postal_code')}}</error>
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

//import widget
import ErrorLabel from '../ErrorLabel.vue';
import DateTimePicker from '../DateTimePicker.vue';

let contractRegister = require('./ContractRegisterModel.js');

export default {
    name: "ConTenantForm",
    components: {
        'contractvilla': ContractVilla,
        'contractcreate': ContractCreate,
        'error': ErrorLabel,
        'dtpicker': DateTimePicker
    },

    data()  {
        return {
            btnSave: false,
            contract: contractRegister.default.createInstance(),
            birthday: moment().format('l')
        }
    },
    methods: {
        onSave() {
            var $this = this;
            var formData = new FormData();
        },
        selectTenant() {
          this.contract.onTenantTypeChange();
        },
        changeDate(name,d) {
            this.contract.changeDate(name,d);
        }
     },
    created() {
        this.contract.create()
     },
     computed: {
       isIndividual(){
         return this.contract.isIndividual()
       },
       isCompany(){
         return this.contract.isCompany()
       }
     },
    watch: {
        birthday() {
            alert(this.birthday);
        }
    }
}

</script>
