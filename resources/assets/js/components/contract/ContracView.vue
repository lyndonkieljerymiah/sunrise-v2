<template>
  <div id="app">
      <div class="container-fluid">
        <div class="col-lg-12">
        <div class="panel panel-green">
            <div class="panel-heading ">Contracts List</div>
            <div class="panel-body">
                    <div class="row">
                      <div class="col-md-4">
                      </div>
                      <div class="col-md-4"></div>
                      <div class="col-md-4">
                        <div class="actions">
                          <a :href="url" class="btn btn-default pull-right" role="button">
                            <i class="fa fa-plus fa-1x" aria-hidden="true"></i> Add Contract
                          </a>
                        </div>
                      </div>
                    </div>
                      <br/>
                    <gridview :data="items" :columns="gridColumns"></gridview>
              </div>
          </div>
        </div>
      </div>
  </div>

</template>


<script>

import GridView from '../GridView.vue';

export default {

    name: "app",
    props: ['url'],
    data: function () {
      return {
        items:[],
        components: {
          'gridview':GridView
        },
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
        ]
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
