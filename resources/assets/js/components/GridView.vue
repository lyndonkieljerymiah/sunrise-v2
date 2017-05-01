<template>
    <table id="grid" class="table table-condensed table-bordered">
        <thead>
            <tr>    
                <th v-for="key in columns"  
                    :style="key.style"
                    @click="sortBy(key)"
                    class="text-center active"
                    :class="{info:sortKey == key.name}">
                    {{ key.column }}
                    <span v-if="key.static == false || key.static === undefined" class="fa fa-fw" :class="sortOrders[key.name] > 0 ? 'fa-sort-asc' : 'fa-sort-desc'"></span>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="entry in filteredData">
                <td v-for="key in columns" :class="key.class" :style="key.style">
                    {{render(entry,key)}}

                    <div v-if="key.name=='action'" class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" >
                            <li v-for="action in actionButtons"><a href="#" @click='actionTrigger(action,entry["id"])'>{{action.name}}</a></li>
                        </ul>
                    </div>
                    
                    <div v-if="key.name=='$markDelete'" class='text-center' @click='actionTrigger("delete",entry["id"])'>
                        <button class="btn btn-danger btn-xs"><i class="fa fa-close"></i></button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    name: "grid",
    props: ['data','columns','filterKey','actions'],
    data() {
        var sortOrders = {};
        this.columns.forEach(function(key) {
            sortOrders[key.name] = 1;
        });

        return {
            sortKey: '',
            sortOrders: sortOrders
        }
    },
    computed: {
        filteredData() {
            var sortKey = this.sortKey;
            var data = this.data;
           
            var order = this.sortOrders[sortKey] || 1
            if(sortKey) {
                data = data.slice().sort(function(a,b) {
                    a = a[sortKey]
                    b = b[sortKey]
                    return (a === b ? 0 : a > b ? 1 : -1) * order
                });
            }
            this.$emit('sorted',sortKey);

            return data;
        },
        actionButtons: function() {
            return this.actions;
        }
    },
    methods: {
        sortBy: function(key) {
            
            if(key.static) 
                return false;
            
            this.sortKey = key.name;
            this.sortOrders[key.name] = this.sortOrders[key.name] * -1;
            
        },
        render: function(entry,key) {
            return entry[key.name];
        },
        actionTrigger: function(action,id) {
            this.$emit('action',action,id);
        }
    }
}
</script>