<template>
  <div id="app">
    <br/>
    <gridview
    :data="contract.data"
    :columns="gridColumns"
    :actions="actions"
    @action="doAction">
  </gridview>
</div>
</template>


<script>

import GridView from '../GridView.vue';

export default {

  name: "pending",
  props: ['contract'],
  components: {
    'gridview': GridView
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
  routes: [
    { path: '/', component: status },
    { path: '/foo', component: status }
  ],
  data: function () {
    return {
      items:[],
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
  }
}

</script>
