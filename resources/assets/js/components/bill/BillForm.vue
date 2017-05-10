<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div>
                    <div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
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
                                <div class="row">
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
                            <div class="col-md-4">
                                <div class="panel panel-info">
                                    <div class="panel-body">
                                        <p class="row">
                                            <strong class="col-md-3">Contract No:</strong>
                                            <span class="col-md-9">{{contract.contract_no}}</span>
                                        </p>
                                        <p class="row">
                                            <strong class="col-md-3">Type:</strong>
                                            <span class="col-md-9">{{contract.full_contract_type}}</span>
                                        </p>
                                        <p class="row">
                                            <strong class="col-md-3">Period:</strong>
                                            <span class="col-md-9">{{contract.period_start}} - {{contract.period_end}}</span>
                                        </p>
                                        <p class="row">
                                            <strong class="col-md-3">Amount:</strong>
                                            <span class="col-md-9">{{contract.amount}}</span>
                                        </p>
                                        <p class="row">
                                            <strong class="col-md-3">Status:</strong>
                                            <span class="col-md-9">{{contract.full_status}}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-info" @click="showModal" style="margin-bottom: 10px;"><i class="fa fa-plus-circle"></i> Add New</button>
                                <modal size="" dialog-title="Payment Entry" @dismiss="onDismissal">
                                    <payment-modal  :bill="bill"></payment-modal>
                                </modal>

                                <gridview :data="bill.data.payments"
                                          :columns="gridColumn"
                                          :lookups="lookups"
                                          @action="onDelete">
                                </gridview>
                                <div class="col-md-4 pull-right">
                                    <strong class="col-md-6">Payment Total:</strong> <strong class="col-md-3 text-right text-warning">{{totalPayment}}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                        <div class="col-md-2 pull-right">
                            <button class="btn btn-info btn-block" @click="save">Save</button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>


    import Toastr from 'vue-toastr';
    import GridView from '../GridView.vue';
    import Modal from '../Modal.vue';

    import PaymentModal from './PaymentModal.vue';
    import ContractInfo from './ContractInfo.vue';

    let billModel = require('./BillModel.js');
    
    export default {
        name: 'billForm',
        props: {
            contractId: 0,
        },
        components: {
            "contractInfo": ContractInfo,
            "gridview": GridView,
            "modal":    Modal,
            "paymentModal": PaymentModal
        },
        data() {

            return {
                bill: billModel.default.createInstance(),
                gridColumn: [
                    {name: 'effectivity_date', column: 'Date', style:'width:10%', class:'text-center'},
                    {name: 'payment_no', column: 'Payment No',style:'width:10%',class:'text-center',editable:true, bind:'payment_no', itype:'text'},
                    {name: 'bank', column: 'Bank', editable:true,bind:'bank',editable:true, bind:'bank', itype:'text'},
                    {name: 'full_payment_mode', column: 'Payment Mode',class:'text-center',
                        editable:true,bind:'payment_mode', itype:'dropdown',selection:'payment_mode'},
                    {name: 'full_payment_type', column: 'Payment Type',class:'text-center'},
                    {name: 'period_start', column: 'Start',class:'text-center'},
                    {name: 'period_end', column: 'End',class:'text-center'},
                    {name: 'amount', column: 'Amount', style:"width:10%",class:'text-right',editable:true, bind:'amount', itype:'text'},
                    {name: 'full_status', column: 'Status',style:"width:10%", class:'text-center'},
                    {name: '$markDelete',column: '',static:true}
                ]

            }
        },
        mounted() {
            let that = this;
            this.bill.create(this.contractId);
        },
        computed: {
            tenant() {
                if(this.bill.contract.tenant !== undefined)
                    return this.bill.contract.tenant;
            },
            villa() {
                if(this.bill.contract.villa !== undefined)
                    return this.bill.contract.villa;
            },
            contract() {
                if(this.bill.contract !== undefined)
                    return this.bill.contract;
            },
            lookups() {
              return this.bill.lookups;
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
            onDismissal(result,cb) {
                if(result) {
                    this.bill.insert();
                    cb(true);
                }
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