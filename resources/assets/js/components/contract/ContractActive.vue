<template>
    <form class="form-horizontal">
        <div class="form-group">
            <label for="payment_type" class="col-md-3">Payment Type</label>
            <div class="col-md-9">
                <select id="payment_type" name="payment_type"
                        class="form-control" @change="onChangePaymentType">
                    <option></option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="payment_type" class="col-md-3">Payment Mode</label>
            <div class="col-md-9">
                <select id="payment_mode" name="payment_mode"
                        class="form-control">
                    <option ></option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="effectivity_date" class="col-md-3">Date of Effectivity</label>
            <div class="col-md-9">
                <input type="text"  class="form-control" name="effectivity_date"
                       id="effectivity_date" autofocus>
            </div>
        </div>

        <div class="form-group">
            <label for="bank"  class="col-md-3">Bank</label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="bank">
                <error :errorDisplay="errors.has('bank')">{{ errors.first('bank') }}</error>
            </div>
        </div>
        <div class="form-group">
            <label for="payment_no" class="col-md-3">Payment No</label>
            <div class="col-md-9">
                <input type="text" v-validate data-vv-rules="required"
                       class="form-control" name="payment_no"
                       required>
                <error></error>
            </div>
        </div>
        <div class="form-group">
            <label for="period_start" class="col-md-3">Period Start</label>
            <div class="col-md-9">
                <input type="text"
                       class="form-control" name="period_start"  required>
                <error></error>
            </div>
        </div>
        <div class="form-group">
            <label for="period_end" class="col-md-3">Period End</label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="period_end" id="period_end" required>
                <error></error>
            </div>
        </div>
        <div class="form-group">
            <label for="amount" class="col-md-3">Amount</label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="amount" id="amount" required>
            </div>
        </div>
    </form>
</template>

<script>
    import ErrorLabel from '../ErrorLabel.vue';

    export default {
        props: {
            contract: {}
        },
        components: {
            'error' : ErrorLabel
        }
    }
</script>
