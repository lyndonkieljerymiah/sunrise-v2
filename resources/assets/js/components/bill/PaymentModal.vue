<template>
    <form class="form-horizontal">
        <div class="form-group">
            <label for="payment_type" class="col-md-3">Payment Type</label>
            <div class="col-md-9">
                <select id="payment_type" name="payment_type" v-model="instance.payment_type"
                        class="form-control">
                    <option v-for="lookup in paymentTerms" v-bind:value="lookup.code">{{lookup.name}}</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="payment_type" class="col-md-3">Payment Mode</label>
            <div class="col-md-9">
                <select id="payment_mode" name="payment_mode" v-model="instance.payment_mode"
                        class="form-control">
                    <option v-for="lookup in paymentModes" v-bind:value="lookup.code">{{lookup.name}}</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="effectivity_date" class="col-md-3">Date of Effectivity</label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="effectivity_date"
                        v-model="instance.effectivity_date" id="effectivity_date">
            </div>
        </div>

        <div class="form-group">
            <label for="bank" class="col-md-3">Bank</label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="bank" v-model="instance.bank" id="bank">
            </div>
        </div>
        <div class="form-group">
            <label for="payment_no" class="col-md-3">Payment No</label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="payment_no" v-model="instance.payment_no" id="payment_no">
            </div>
        </div>
        <div class="form-group">
            <label for="period_start" class="col-md-3">Period Start</label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="period_start" v-model="instance.period_start" id="period_start">
            </div>
        </div>
        <div class="form-group">
            <label for="period_end" class="col-md-3">Period End</label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="period_end" v-model="instance.period_end" id="period_end">
            </div>
        </div>


    </form>
</template>


<script>
    export default {
        props: {
            instance: {},
            paymentModes: {required:true},
            paymentTerms: {required:true}
        },
        data() {
          return {

          }
        },
        show() {
            window.VueEvent.$on("ActivatePaymentDialog",() => {
                bbox.dialog({
                    size: that.size,
                    title: "Payment Entry",
                    message: $('#paymentFormDialog').clone(),
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger'
                        }
                    },
                    callback(result) {
                        this.$emit(result);
                    }
                });
            });
        }
    }
</script>

<style>
    .is-dialog {
        style:none;
    }
</style>
