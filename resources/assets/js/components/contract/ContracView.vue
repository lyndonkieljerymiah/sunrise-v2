  <template>
  <div id="app">
      <div class="container-fluid">
        <div class="col-lg-12">
        <div class="panel panel-green">
            <div class="panel-heading ">Contracts List</div>
            <div class="panel-body">

              <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#pending">Pending</a></li>
                <li><a data-toggle="tab" href="#menu1">Active</a></li>
                <div class="actions">
                  <a :href="url" class="btn btn-default pull-right" role="button">
                    <i class="fa fa-plus fa-1x" aria-hidden="true"></i> Add Contract
                  </a>
                </div>
              </ul>
              <div class="tab-content">
                <div id="pending" class="tab-pane fade in active">
                    <contract-active></contract-active>
                </div>
                <div id="menu1" class="tab-pane fade">
                  <contract-pending></Contract-pending>
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

export default {

    name: "app",
    props: ['url'],
    components: {
        'gridview'  : GridView,
        'contractactive': ContractActive,
        'contractpending': ContractPending,
    }
  }


</script>
