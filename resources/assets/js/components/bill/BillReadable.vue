<template>
    <div id="app" class="form-horizontal">
        <div class="form-group">
            <div class="col-md-8">

            </div>
            <div class="col-md-4">
                <div class="panel panel-info">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-8">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <div class="col-md-3 col-md-offset-9 text-right">

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


    export default {
        props: {
            billNo:0
        },
        data() {
            return {
                bill: {},
                contract: {}
            }
        },
        mounted() {

            AjaxRequest.get('bill','show',this.billNo).then(r => {

                this.bill = r.data.bill;

                this.contract = r.data.contract;
            });
        }

    }

</script>