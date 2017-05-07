  <template>
  <div id="app">
      <div class="container-fluid">
        <div class="col-lg-12">
        <div class="panel panel-green">
            <div class="panel-heading ">Contracts List</div>
            <div class="panel-body">
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
                      :actions="actions"
                      @action="doAction"
                      :columns="gridColumns">
                  </gridview>
                </div>
              </div>
              </div>
          </div>
        </div>
      </div>
  </div>

</template>


<script>
import GridView from '../GridView.vue';
import ContractActive from './ContractActive.vue';
import ContractPending from './ContractPending.vue';

let model = require('./ContractListModel.js');


export default {
    data() {
      return {
         contract: model.default.newInstance(),
          gridColumns: [
          {name: 'created_at', column: 'Date'},
          {name: 'contract_no', column: 'Contract No'},
          {name: 'contract_type', column: 'Contract Type'},
          {name: 'period_start', column: 'Period Start'},
          {name: 'period_end', column: 'Period End'},
          {name: 'amount', column: 'Amount'},
          {name: 'full_name', column: 'Tenant Id'},
          {name: 'villa_no', column: 'Villa No'},
          {name: 'status', column: 'Status'},
          {name: 'action', column: '',static:true, class: 'text-center'}],

          actions: [
              {key:'approved', name:'Approved'},
              {key:'cancelled', name:'Cancelled'},
              {key:'remove',name:'Remove'}
          ]
      }
    },
    name: "app",
    props: ['url'],
    components: {
        'gridview'  : GridView
    },
    created(){

        this.contract.create();
    },
    methods: {
      change(status) {
          this.contract.create(status);
      }
    },
    computed: {
      contractData() {
        return this.contract.data;
      }
    }
  }


</script>
