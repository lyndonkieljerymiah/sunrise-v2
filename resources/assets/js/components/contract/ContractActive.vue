<template>

  <div id="app">
    <br/>
    <gridview
    :data="contractData"
    :columns="gridColumns"
    :actions="actions"
    @action="doAction">
  </gridview>
  <div v-for="d in contractData"> 
  {{d.amount}}
  </div>
</div>
</template>

<script>

import GridView from '../GridView.vue';
let model = require('./ContractListModel.js');

export default {

  name: "active",
  props: ['url'],
  components: {
    'gridview': GridView
  },
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
            {key:'terminated', name:'Terminate'},
            {key:'renew', name:'Renew'},
            {key:'remove',name:'Remove'}
        ],
    }
  },
  methods: {
      doAction(a, contract_no) {
           if(a.key == 'renew') {
              var redirectToEdit = this.url + "/" + contract_no;
              AjaxRequest.route(redirectToEdit);
          }
      },
      addNew() {
          AjaxRequest.route(this.url);
      }
  },
  created() {
    this.contract.create();
    
  },
  computed: {
    contractData() {
      return this.contract.data;
    }
  }
}

</script>
