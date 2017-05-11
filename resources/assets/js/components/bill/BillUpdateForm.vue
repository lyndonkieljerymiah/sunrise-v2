<template>
    <div>
        <div class="row">
            <div class="col-md-4" style="margin-bottom: 10px;">
                <div class="form-inline">
                    <div class="form-group">
                        <input type="text"  placeholder="Bill No" class="form-control" name="billSearch" v-model="viewModel.billNo" />
                    </div>
                    <button class="btn btn-info" @click="search"><i class="fa " :class="viewIcon()"></i></button>
                </div>
            </div>
            <div class="col-md-12">
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
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Pending</a></li>
                                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Dishonored</a></li>
                                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Completed</a></li>
                                </ul>
                            </div>
                            <div class="col-md-12">
                                <gridview
                                    :data="bill.payments"
                                    :columns="gridColumn"
                                    :lookups="viewModel.lookups">
                                    <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                </gridview>
                            </div>
                            <div class="col-md-2 col-md-offset-10 ">
                                <button class="btn btn-info btn-block" style="margin-bottom: 10px;">Add New</button>
                            </div>
                            <hr/>
                            <div class="col-md-4 col-md-offset-8">
                                <strong class="col-md-6">Payment Total:</strong> <strong class="col-md-3 text-right text-warning"></strong>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-2 pull-right">
                                <button class="btn btn-info btn-block">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    class BillUpdateViewModel {
        constructor() {
            this.billNo = "";
            this.isLoading = false;
            this.data = {
                contract: { tenant:{},villa:{}},
                bill:{
                    payments:[]
                }
            };
            this.lookups = [];
            this.errors = new ErrorValidations.newInstance();
        }
        create() {
            this.isLoading = true;
            AjaxRequest.get('bill','edit',this.billNo)
                .then(res => {
                    this.data.bill = res.data.bill;
                    this.data.contract = res.data.contract;
                    this.lookups = res.data.lookups;
                    this.billNo = "";
                    this.isLoading = false;
                })
                .catch(err => {
                    this.isLoading = false;
                });
        }
    }

    import GridView from '../GridView.vue';

    export default {
        data() {
            return {
                viewModel: new BillUpdateViewModel(),
                gridColumn: [
                    {name: 'effectivity_date', column: 'Date', class:'text-center', default:true, dtype:'date'},
                    {name: 'payment_no', column: 'No',style:'width:10%',class:'text-center'},
                    {name: 'period_start', column: 'Start',class:'text-center',dtype:'date'},
                    {name: 'period_end', column: 'End',class:'text-center',dtype:'date'},
                    {name: 'amount', column: 'Amount', style:"width:10%",class:'text-right', dtype:'currency'},
                    {name: 'full_status', column: 'Status',style:"width:10%", class:'text-center', editable:true,bind:'status',itype:'dropdown',selection:'payment_status'},
                    {name: '$custom',column: '',static:true}
                ]
            }
        },
        components: {
            "gridview": GridView
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
            }

        },
        methods: {
            search() {
                this.viewModel.create();
            },
            viewIcon() {
                return this.viewModel.isLoading ? "fa-refresh fa-spin" : "fa-search";
            }
        }

    }
</script>

<style>

</style>