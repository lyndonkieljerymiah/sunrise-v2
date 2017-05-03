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
                    <div class="panel-body">
                        <button class="btn btn-info btn-block" @click="save">Save</button>
                    </div>
                </div>
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
                            <strong class="col-md-3">Type:</strong>
                            <span class="col-md-9">{{contract.full_contract_type}}</span>
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
                        <modal size="" dialog-title="Payment Entry" @dismiss="onDismissal">
                            <payment-modal
                                    :instance="bill.cloneOfInstance"
                                    :payment-terms="lookups.payment_term"
                                    :payment-modes="lookups.payment_mode">
                            </payment-modal>
                        </modal>
                        <gridview :data="bill.payments"
                                  :columns="gridColumn"
                                    @action="onDelete">
                        </gridview>
                        <div class="col-md-3 col-md-offset-9 text-right">
                            <strong>Payment Total:</strong>{{totalPayment}}
                        </div>
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

    let billModel = require('./BillModel.js');
    
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
                    tenant:{},
                    villa:{}
                },
                bill: billModel.default.createInstance(),
                instance: {},
                lookups: [],
                gridColumn: [
                    {name: 'effectivity_date', column: 'Date', style:'width:10%',class:'text-center'},
                    {name: 'payment_no', column: 'Payment No'},
                    {name: 'bank', column: 'Bank'},
                    {name: 'full_payment_mode', column: 'Payment Mode'},
                    {name: 'full_payment_type', column: 'Payment Type'},
                    {name: 'amount', column: 'Amount'},
                    {name: 'full_status', column: 'Status'},
                    {name: '$markDelete',column: '',static:true}
                ],
                error: ErrorValidations.newInstance()
            }
        },
        mounted() {
            let that = this;

            AjaxRequest.get('bill', 'create', this.contractId)
                .then(r => {
                    that.contract = r.data.contract;
                    that.lookups = r.data.lookups;
                    that.bill.bind(r.data.bill);
                    that.paymentInit();
                })
                .catch(e => {
                    this.error.register(e.data)
                });
        },
        computed: {
            tenant() {
                if(this.contract.tenant !== undefined)
                    return this.contract.tenant;
            },
            villa() {
                if(this.contract.villa !== undefined)
                    return this.contract.villa;
            },
            totalPayment() {
                return this.bill.totalAmount();
            }
        },
        methods: {
            showModal() {
                //make copy of instance
                this.paymentInit();
                VueEvent.$emit('onModalActive');
            },
            paymentInit() {
               this.bill.createInstance();
            },
            onDismissal(result) {
                var that = this;
                if(result) 
                    this.bill.insert((payment) => {
                        that.lookups.payment_mode.forEach(function(item) {
                            if(item.code === payment.payment_mode) {
                                payment.full_payment_mode = item.name;
                            }

                        });
                        that.lookups.payment_mode.forEach(function(item) {
                            if(item.code === payment.payment_mode) {
                                payment.full_payment_mode = item.name;
                            }

                        });
                    });
            },
            onDelete(a,id) {
                var that = this;
                bbox.confirm({
                    title: "Remove Payment",
                    message: "Are you sure want to remove item?",
                    callback(result)  {
                        if(result) {
                            that.bill.removePayment(id);
                        }
                    }
                });
            },
            save() {
                this.bill.saveChanges();
            }

        }
    }
</script>