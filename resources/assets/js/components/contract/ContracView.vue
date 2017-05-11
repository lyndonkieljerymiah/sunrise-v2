  <template>
  <div id="app">
      <div class="container-fluid">
        <div class="col-lg-12">



              <ul class="nav nav-tabs">
                <li class="active" @click="change('pending')"><a data-toggle="tab" href="#pending">Pending</a></li>
                <li><a data-toggle="tab" href="#active" @click="change('active')">Active</a></li>
                <div class="actions">
                  <a :href="url" class="btn btn-default pull-right" role="button">
                    <i class="fa fa-plus fa-1x" aria-hidden="true"></i> Add Contract
                  </a>
                </div>
              </ul>
              <div class="tab-content">
                <div id="pending" class="tab-pane fade in active">
                    <gridview
                      :data="contractData"
                      :columns="gridColumns"
                      :actions="actions"
                      @action="doAction">
                  </gridview>
                </div>

                <modal size="" dialog-title="Contract Renewal" @dismiss="onDismissal">
                    <contract-modal :renewal="renewal"></contract-modal>
                </modal>

              </div>
              </div>


      </div>
  </div>

</template>


<script>
import GridView from '../GridView.vue';
import ContractActive from './ContractActive.vue';
import ContractPending from './ContractPending.vue';
import ContractModal from './ContractModal.vue';
import Modal from '../Modal.vue';

let model = require('./ContractListModel.js');


export default {
    data() {
      return {
         contract: model.default.newInstance(),
         renewal: model.default.newInstanceRenewal(),
          gridColumns: [
          {name: 'created_at', column: 'Date', default: true, dtype: 'date'},
          {name: 'contract_no', column: 'Contract No'},
          {name: 'contract_type', column: 'Contract Type'},
          {name: 'period_start', column: 'Period Start', dtype: 'date'},
          {name: 'period_end', column: 'Period End', dtype: 'date'},
          {name: 'amount', column: 'Amount', dtype: 'currency'},
          {name: 'full_name', column: 'Tenant Id'},
          {name: 'villa_no', column: 'Villa No'},
          {name: 'status', column: 'Status'},
          {name: 'action', column: '',static:true, class: 'text-center'}],

          actions: [
            {key:'create', name:'Create Bill'},
            {key:'cancelled', name:'Cancelled'},
            {key:'remove',name:'Remove'}
          ]
      }
    },
    name: "app",
    props: ['url'],
    components: {
        'gridview'  : GridView,
        'modal' : Modal
    },
    created(){
        this.contract.create();
    },
    methods: {
      change(status) {
          this.contract.create(status);
          if(status == 'pending') {
            this.actions = [
                {key:'create', name:'Create Bill'},
                {key:'cancelled', name:'Cancelled'},
                {key:'remove',name:'Remove'}
            ]
          }else {
            this.actions = [
                {key:'terminated', name:'Terminated'},
                {key:'renew', name:'Renew'}
            ]
          }
      },
      doAction(a,id) {
        if(a.key == 'create') {
          this.contract.createBill(id);

       } else if (a.key == 'renew') {
         this.renewal.create(id, function() {
          VueEvent.$emit('onModalActive');
         });

       } else if (a.key == 'cancelled') {
         this.contract.cancel(id);
       }
     },
     onDismissal(result, fn) {
       var that = this;
       if(result) {
         this.renewal.save();
        fn(false)
       }
     }
    },
    computed: {
      contractData() {
        return this.contract.data;
      }
    }
  }


</script>
