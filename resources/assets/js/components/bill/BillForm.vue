<template>
    <div id="app" class="form-horizontal">
        <div class="form-group">
            <div class="col-md-8">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <span></span>
                        <strong>Tenant Information</strong>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <p>
                                <strong class="col-md-2">Code:</strong>
                                <span class="col-md-10">{{tenant.code}}</span>
                            </p>
                            <p>
                                <strong class="col-md-2">Full Name:</strong>
                                <span class="col-md-10">{{tenant.full_name}}</span>
                            </p>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <p>
                                <strong class="col-md-2">Villa No:</strong>
                                <span class="col-md-10">{{villa.villa_no}}</span>
                            </p>
                            <p>
                                <strong class="col-md-2">Description:</strong>
                                <span class="col-md-10">{{villa.description}}</span>
                            </p>
                            <p>
                                <strong class="col-md-2">Rate/Month:</strong>
                                <span class="col-md-10">{{villa.rate_per_month}}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <strong>Contract</strong>
                    </div>
                    <div class="panel-body">
                        <p>
                            <strong class="col-md-3">Contract No:</strong>
                            <span class="col-md-9">{{contract.contract_no}}</span>
                        </p>
                        <p>
                            <strong class="col-md-3">Period:</strong>
                            <span class="col-md-9">From {{contract.period_start}} To {{contract.period_end}}</span>
                        </p>
                        <p>
                            <strong class="col-md-3">Amount:</strong>
                            <span class="col-md-9">{{contract.amount}}</span>
                        </p>
                        <p>
                            <strong class="col-md-3">Status:</strong>
                            <span class="col-md-9">{{contract.full_status}}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-8">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <button class="btn btn-info" @click="showModal">Add New</button>
                        <modal size="" dialog-title="Payment Entry">
                            <payment-modal
                                    :instance="instance"
                                    :payment-terms="lookups.payment_term"
                                    :payment-modes="lookups.payment_mode">
                            </payment-modal>
                        </modal>
                        <gridview :data="bill.payments"
                                  :columns="gridColumn">
                        </gridview>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>

    import GridView from '../GridView.vue';
    import Modal from '../Modal.vue';
    import PaymentModal from './PaymentModal.vue';

    export default {
        name: 'billForm',
        props: {
            contractId: 0
        },
        components: {
            "gridview": GridView,
            "modal":    Modal,
            "paymentModal": PaymentModal
        },
        data() {
            return {
                contract: {
                    associates: {
                        tenant: {},
                        villa: {}
                    }
                },
                bill: {
                    payments: [],
                    instance: {}
                },
                instance: {},
                lookups: [],
                gridColumn: [
                    {name: 'effectivity_date', column: 'Date'},
                    {name: 'payment_no', column: 'Payment No'},
                    {name: 'bank', column: 'Bank'},
                    {name: 'payment_mode', column: 'Payment Mode'},
                    {name: 'payment_type', column: 'Payment Type'}
                ],
                error: ErrorValidations.newInstance()
            }
        },
        created() {
            var that = this;

            AjaxRequest.get('bill', 'create', this.contractId)
                .then(r => {

                    that.contract = r.data.contract;
                    that.lookups = r.data.lookups;
                    that.bill = r.data.bill;

                    //format date
                    that.bill.instance.effectivity_date = moment(that.bill.instance.effectivity_date).format('L');
                    that.bill.instance.period_start = moment(that.bill.instance.period_start).format('L');
                    that.bill.instance.period_end = moment(that.bill.instance.period_end).format('L');


                    that.paymentInit();
                })
                .catch(e => {
                    this.error.register(e.data)
                });
        },
        computed: {
            tenant() {
                return this.contract.associates.tenant;
            },
            villa() {
                return this.contract.associates.villa;
            },
            paymentTerms() {
                if(this.lookups.payment_term !== undefined)
                    return this.lookups.payment_term;
            },
            paymentModes() {
                if(this.lookups.payment_mode !== undefined)
                    return this.lookups.payment_mode;
            },
        },
        methods: {
            showModal() {
                //make copy of instance
                //this.instance =  window.objectClone(this.bill.instance);
                VueEvent.$emit('onModalActive');
            },
            paymentInit() {
                this.instance = window.objectClone(this.bill.instance);

            }

        }
    }
</script>