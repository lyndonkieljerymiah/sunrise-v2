<template>
    <div id="app">
        <div class="row">
            <div class="col-md-8">
                <tenant-info :tenant-data="tenant" :villa-data="villa">
                    <gridview :data="bill.payments"
                            :columns="gridColumn">
                    </gridview>   
                </tenant-info>
            </div>
            <div class="col-md-4">
                <contract-info :contract-data="contract"></contract-info>
            </div>

        </div>
       
    </div>
</template>
<script>


    import GridView from '../GridView.vue';
    import Modal from '../Modal.vue';

    import TenantInfo from './TenantInfo.vue';
    import ContractInfo from './ContractInfo.vue';
    

    export default {
        props: {
            billNo:0
        },
        components:{
            'tenantInfo': TenantInfo,
            'contractInfo':ContractInfo,
            'gridview': GridView
        },
        data() {
            return {
                bill: {},
                contract: {
                    tenant:{},
                    villa:{}
                },
                gridColumn: [
                {name: 'effectivity_date', column: 'Date', style:'width:10%',class:'text-center', static: true},
                {name: 'payment_no', column: 'Payment No',static: true},
                {name: 'bank', column: 'Bank',static: true},
                {name: 'full_payment_mode', column: 'Payment Mode',static: true},
                {name: 'full_payment_type', column: 'Payment Type',static: true},
                {name: 'amount', column: 'Amount',static: true},
                {name: 'full_status', column: 'Status',static: true}
                ]
            }
        },
        created() {
            AjaxRequest.get('bill','show',this.billNo).then(r => {
                this.bill = r.data.bill;
                this.contract = r.data.contract;
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
            contract() {
                return this.contract;
            }
        }

    }

</script>