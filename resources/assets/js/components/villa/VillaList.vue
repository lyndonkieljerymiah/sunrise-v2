<template>
    <div id="app">
        <div class="row">
            <div class="col-md-6">
                <searchbox @trigger="search" :field-list="filterFields"></searchbox>
            </div>
            <div class="col-md-2 col-md-offset-4">
                <button class="btn btn-info" @click="addNew()"> <i class="fa fa-plus"></i> Add New </button>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-9">
                <gridview
                    :data="viewModel.data.list"
                    :columns="gridColumns"
                    :actions="actions"
                    @action="doAction"
                    @sorted="sorted">
                </gridview>
            </div>
            <div class="col-md-3">
                <div class="list-group">
                    <a href="#" class="list-group-item" v-for="count in statusCount">
                        <i class="fa fa-home fa-fw fa-lg"></i> {{count.status}}
                        <span class="badge">{{count.count}}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import SearchBox from '../SearchBox.vue';
    import GridView from '../GridView.vue';

    import {VillaListViewModel} from './VillaViewModel';

    export default {
        name: 'list',
        components: {
            'searchbox' : SearchBox,
            'gridview'  : GridView
        },
        methods: {
            search(field) {
                
            },
            doAction(a,id) {
                 if(a.key == 'edit') {
                    this.viewModel.redirectToRegister(id);
                }
            },
            addNew() {
                this.viewModel.redirectToRegister();
            },
            sorted(sortKey) {
                    this.filterKey = sortKey;
            }
        },
        data()  {
            return {
                viewModel: new VillaListViewModel(),
                filterKey: "",
                filterFields: [
                    {name: 'villa_no', text: 'Villa No' },
                    {name: 'location', text: 'Location'},
                    {name: 'villa_class', text: 'Class'},
                    {name: 'rate_per_month', text: 'Rate/Month'},
                    {name: 'status', text: 'Status'},
                ],
                gridColumns: [
                    {name: 'villa_no', column: 'Villa No', style: 'width:10%',class:'text-center'},
                    {name: 'location', column: 'Location'},
                    {name: 'electricity_no', column: 'Electricity No'},
                    {name: 'water_no', column: 'Water No'},
                    {name: 'qtel_no', column: 'QTel No'},
                    {name: 'villa_class', column: 'Class'},
                    {name: 'rate_per_month', column: 'Rate/Month', class:'text-right'},
                    {name: 'status', column: 'Status', class:'text-center',style: 'width:10%'},
                    {name: 'action', column: '',static:true, class: 'text-center'}],
                actions: [
                    {key:'edit', name:'Edit'},
                    {key:'remove',name:'Remove'}
                ]
            }
        },
        mounted() {
            this.viewModel.create();
        },
        computed: {
          statusCount() {
              return this.viewModel.data.status;
          }
        }
    }
</script>
