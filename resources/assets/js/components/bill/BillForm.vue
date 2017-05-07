<template>
    <div id="app">
        <div class="row">
            <div class="col-md-8">
                <tenant-info :tenant-data="tenant" :villa-data="villa">
                    <div>
                        <button class="btn btn-info" @click="showModal" style="margin-bottom: 10px;">Add New</button>
                        <modal size="" dialog-title="Payment Entry" @dismiss="onDismissal">
                            <payment-modal  :bill="bill"></payment-modal>
                        </modal>
                        <gridview :data="bill.data.payments"
                                  :columns="gridColumn"
                                  @action="onDelete">
                        </gridview>
                        <div class="col-md-4 pull-right">
                            <strong class="col-md-6">Payment Total:</strong> <strong class="col-md-3 text-right text-warning">{{totalPayment}}</strong>
                        </div>
                    </div>
                </tenant-info>
            </div>
            <div class="col-md-4">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <button class="btn btn-info btn-block" @click="save">Save</button>
                    </div>
                </div>
                <contract-info :contract-data="contract"></contract-info>
            </div>
        </div>
    </div>
</template>

<script>
    import GridView from '../GridView.vue';
    import Modal from '../Modal.vue';
    import PaymentModal from './PaymentModal.vue';
    import TenantInfo from './TenantInfo.vue';
    import ContractInfo from './ContractInfo.vue';
    import Toastr from 'vue-toastr';

    let billModel = require('./BillModel.js');
    
    export default {
        name: 'billForm',
        props: {
            contractId: 0,
        },
        components: {
            "tenantInfo": TenantInfo,
            "contractInfo": ContractInfo,
            "gridview": GridView,
            "modal":    Modal,
            "paymentModal": PaymentModal
        },
        data() {
            return {
                bill: billModel.default.createInstance(),
                gridColumn: [
                    {name: 'effectivity_date', column: 'Date', style:'width:10%',class:'text-center'},
                    {name: 'payment_no', column: 'Payment No'},
                    {name: 'bank', column: 'Bank'},
                    {name: 'full_payment_mode', column: 'Payment Mode'},
                    {name: 'full_payment_type', column: 'Payment Type'},
                    {name: 'amount', column: 'Amount'},
                    {name: 'full_status', column: 'Status'},
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
                if(result) {
                    this.bill.insert();
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