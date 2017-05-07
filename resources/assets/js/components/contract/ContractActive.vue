<template>
  <div id="app">
    <br/>
    <gridview
    :data="items"
    :columns="gridColumns"
    :actions="actions"
    @action="doAction">
  </gridview>
</div>
</template>


<script>

import GridView from '../GridView.vue';
export default {

  name: "app",
  props: ['url'],
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
            {key:'terminated', name:'Terminate'},
            {key:'renew', name:'Renew'},
            {key:'remove',name:'Remove'}
        ],
        statusCounts: []


    }
  },

  created() {
        var self = this;
        AjaxRequest.get("contract", "list")
        .then(response=> {
          self.items = response.data;
        });

  }
}

</script>
