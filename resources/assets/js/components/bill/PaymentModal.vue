<template>
    <div class="form-horizontal">
        <div class="form-group">
            <label for="payment_type" class="col-md-3">Payment Type</label>
            <div class="col-md-9">
                <select id="payment_type" name="payment_type" v-model="bill.cloneOfInstance.payment_type"
                        class="form-control" @change="onChangePaymentType">
                    <option v-for="lookup in bill.lookups.payment_term" v-bind:value="lookup.code">{{lookup.name}}</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="payment_type" class="col-md-3">Payment Mode</label>
            <div class="col-md-9">
                <select id="payment_mode" name="payment_mode" v-model="bill.cloneOfInstance.payment_mode"
                        class="form-control">
                    <option v-for="lookup in bill.lookups.payment_mode" v-bind:value="lookup.code">{{lookup.name}}</option>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label for="effectivity_date" class="col-md-3">Date of Effectivity</label>
            <div class="col-md-9">
                <dtpicker dp-name="effectivity_date"  :value="bill.cloneOfInstance.effectivity_date" @pick="bill.cloneOfInstance.effectivity_date = $event"></dtpicker>
                <error :errorDisplay="errors.has('effectivity_date')">{{errors.first('effectivity_date')}}</error>
            </div>
        </div>
     
        <div class="form-group">
            <label for="bank"  class="col-md-3">Bank</label>
            <div class="col-md-9">
                <input type="text" :disabled="paymentModeCash" class="form-control" name="bank" v-model="bill.cloneOfInstance.bank">
                <error :errorDisplay="errors.has('bank')">{{ errors.first('bank') }}</error>
            </div>
        </div>
        <div class="form-group">
            <label for="payment_no" class="col-md-3">Payment No</label>
            <div class="col-md-9">
                <input type="text"
                       :disabled="paymentModeCash" class="form-control" name="payment_no"
                       v-model="bill.cloneOfInstance.payment_no" required>
                <error :errorDisplay="errors.has('payment_no')">{{ errors.first('payment_no') }}</error>
            </div>
        </div>
        <div class="form-group">
            <label for="period_start" class="col-md-3">Period Start</label>
            <div class="col-md-9">
                <dtpicker dp-name="period_start" :value="bill.cloneOfInstance.period_start" @pick="bill.cloneOfInstance.period_start = $event"></dtpicker>
                <error :errorDisplay="errors.has('period_start')">{{ errors.first('period_start') }}</error>
            </div>
        </div>
        <div class="form-group">
            <label for="period_end" class="col-md-3">Period End</label>
            <div class="col-md-9">
                <dtpicker dp-name="period_end" :value="bill.cloneOfInstance.period_end" @pick="bill.cloneOfInstance.period_end = $event"></dtpicker>
                <error :errorDisplay="errors.has('period_end')">{{ errors.first('period_end') }}</error>
            </div>
        </div>
        <div class="form-group">
            <label for="amount" class="col-md-3">Amount</label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="amount" v-model="bill.cloneOfInstance.amount" id="amount" required>
            </div>
        </div>
    </div>
</template>

<script>

    import ErrorLabel from '../ErrorLabel.vue';
    import DateTimePicker from '../DateTimePicker.vue';

    export default {
        props: {
            bill: {}
        },
        components: {
            'error' : ErrorLabel,
            'dtpicker': DateTimePicker
        },
        methods: {
            onChangePaymentType() {
                this.bill.changePaymentType();
            },
            changeDate(name,d) {
                this.bill.changeDate(name,d);
            }
        },
        computed: {
            paymentModeCash: function() {
                return this.bill.isPaymentCash();
            }
        }
    }
</script>


