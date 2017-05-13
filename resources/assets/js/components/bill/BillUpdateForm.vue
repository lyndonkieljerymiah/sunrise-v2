<template>
    <div>
        <div class="row">
            <div class="col-md-4 col-md-offset-8" style="margin-bottom: 10px;">
                <div class="form-inline">
                    <div class="form-group">
                        <input type="text"  placeholder="Bill No" class="form-control" name="billSearch" v-model="viewModel.billNo" />
                    </div>
                    <button class="btn btn-info" @click="search"><i class="fa " :class="busySearch ? 'fa-refresh fa-spin' : 'fa-search'"></i></button>
                </div>
            </div>

            <div v-if="bill.id"  class="col-md-12">
                <div>
                    <div>
                        <div class="row">
                            <div class="col-md-8">
                                <p class="row">
                                    <strong class="col-md-2">Code:</strong>
                                    <span class="col-md-10">{{tenant.code}}</span>
                                </p>
                                <p class="row">
                                    <strong class="col-md-2">Full Name:</strong>
                                    <span class="col-md-10">{{tenant.full_name}}</span>
                                </p>
                                <hr/>
                                <p class="row">
                                    <strong class="col-md-2">Villa No:</strong>
                                    <span class="col-md-10">{{villa.villa_no}}</span>
                                </p>
                                <p class="row">
                                    <strong class="col-md-2">Description:</strong>
                                    <span class="col-md-10">{{villa.description}}</span>
                                </p>
                                <p class="row">
                                    <strong class="col-md-2">Rate/Month:</strong>
                                    <span class="col-md-10">{{villa.rate_per_month}}</span>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 >Bill No: {{bill.bill_no}}</h3>
                                    </div>
                                </div>
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
                                            <span class="col-md-9">{{contract.period_start | toDateFormat}} - {{contract.period_end | toDateFormat}}</span>
                                        </p>
                                        <p class="row">
                                            <strong class="col-md-3">Amount:</strong>
                                            <span class="col-md-9">{{contract.amount | toCurrencyFormat }}</span>
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
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" >
                                    <li :class="{active:tabIndex == 'pending'}">
                                        <a href="#" @click="changeTab('pending', 'received')">For Clearing</a>
                                    </li>
                                    <li :class="{active:tabIndex == 'adjust'}">
                                        <a href="#" @click="changeTab('adjust','bounce')">Cancelled</a></li>
                                    <li :class="{active:tabIndex == 'completed'}">
                                        <a href="#" @click="changeTab('completed','clear')">Completed</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active">
                                    <div class="col-md-12" id="main">
                                        <gridview
                                            :data="bill.payments"
                                            :columns="gridColumn"
                                            :lookups="viewModel.lookups">
                                            <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                        </gridview>
                                    </div>
                                    <div class="col-md-2 col-md-offset-10" style="margin-bottom:10px;">
                                        <button class="btn btn-default btn-block" @click="showModal">New Cheque</button>
                                    </div>
                                    <modal size="" dialog-title="Payment Entry" @dismiss="onDismissal">

                                    </modal>
                                    <hr/>
                                    <div class="col-md-3 col-md-offset-9">
                                        <total-payment :payment="totalPayment"></total-payment>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-2 pull-right">
                                <button v-if="tabIndex == 'pending'" class="btn btn-info btn-block" @click="save"><i class="fa fa-fw fa-lg" :class="busySave ? 'fa-refresh fa-spin' : 'fa-save'"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>



    function columnFactory(value) {
        switch(value) {
            case 'adjust':
                return [
                    {name: 'effectivity_date', column: 'Date', style:'width:10%', class:'text-center', default:true, dtype:'date'},
                    {name: 'payment_no', column: 'No',style:'width:10%',class:'text-center'},
                    {name: 'bank', column: 'Bank',style:'width:10%',class:'text-center'},
                    {name: 'period_start', column: 'Start',class:'text-center',dtype:'date'},
                    {name: 'period_end', column: 'End',class:'text-center',dtype:'date'},
                    {name: 'amount', column: 'Amount', style:"width:10%",class:'text-right', dtype:'currency'},
                    {name: 'full_status', column: 'Status',style:"width:10%", class:'text-center', editable:true,bind:'status',itype:'dropdown',selection:'payment_status'},
                    {name: 'remarks', column: 'Remarks',style:'width:20%',class:'text-center', editable:true,bind:'remarks',itype:'textarea'},
                    {name: '$custom',column: '',static:true}];
            case 'completed':
                return [
                    {name: 'effectivity_date', column: 'Date', style:'width:10%', class:'text-center', default:true, dtype:'date'},
                    {name: 'payment_no', column: 'No',style:'width:10%',class:'text-center'},
                    {name: 'bank', column: 'Bank',style:'width:10%',class:'text-center'},
                    {name: 'period_start', column: 'Start',class:'text-center',dtype:'date'},
                    {name: 'period_end', column: 'End',class:'text-center',dtype:'date'},
                    {name: 'amount', column: 'Amount', style:"width:10%",class:'text-right', dtype:'currency'},
                    {name: 'full_status', column: 'Status',style:"width:10%", class:'text-center' },
                    {name: 'remarks', column: 'Remarks',style:'width:20%',class:'text-center'}]
            default:
                return [
                    {name: 'effectivity_date', column: 'Date', style:'width:10%', class:'text-center', default:true, dtype:'date'},
                    {name: 'payment_no', column: 'No',style:'width:10%',class:'text-center'},
                    {name: 'bank', column: 'Bank',style:'width:10%',class:'text-center'},
                    {name: 'period_start', column: 'Start',class:'text-center',dtype:'date'},
                    {name: 'period_end', column: 'End',class:'text-center',dtype:'date'},
                    {name: 'amount', column: 'Amount', style:"width:10%",class:'text-right', dtype:'currency'},
                    {name: 'full_status', column: 'Status',style:"width:10%", class:'text-center', editable:true,bind:'status',itype:'dropdown',selection:'payment_status'},
                    {name: 'remarks', column: 'Remarks',style:'width:20%',class:'text-center', editable:true,bind:'remarks',itype:'textarea'},
                    {name: '$custom',column: '',static:true}];
        }

    }

    import GridView from '../GridView.vue';
    import Modal from '../Modal.vue';

    import TotalPayment from './TotalPayment.vue';

    let modelInstance = require('./BillModel.js');

    export default {
        data() {

            let gridColumn = columnFactory();
            let viewModel = modelInstance.default.createBillViewModelInstance();
            return {
                viewModel: viewModel,
                gridColumn: gridColumn
            }
        },
        components: {
            "gridview": GridView,
            'totalPayment': TotalPayment,
            "modal": Modal
        },
        mounted() {

        },
        computed: {
            tenant() {
                return this.viewModel.data.contract.tenant;
            },
            villa() {
                return this.viewModel.data.contract.villa;
            },
            contract() {
                return this.viewModel.data.contract;
            },
            bill() {
                return this.viewModel.data.bill;
            },
            payments() {
                return this.viewModel.bill.payments;
            },
            busySearch() {
                return this.viewModel.loadingIs('search');
            },
            busySave() {
                return this.viewModel.loadingIs('save');
            },
            tabIndex() {
                return this.viewModel.currentTabIndex;
            },
            totalPayment() {
                return this.viewModel.data.bill.paymentSummary ;
            }

        },
        methods: {
            showModal() {
                VueEvent.$emit('onModalActive');
            },
            search() {
                this.viewModel.create();
            },
            save() {
                this.viewModel.save();
            },
            changeTab(tabIndex,status) {

                this.viewModel.getPayment(status);
                this.viewModel.currentTabIndex = tabIndex;
                this.gridColumn = columnFactory(tabIndex);
            },
            onDismissal(result) {

            }
        }

    }
</script>

<style>

</style>