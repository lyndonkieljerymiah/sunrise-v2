<template>
    <table id="grid" class="table table-condensed table-hover">
        <thead>
        <tr class="active">

            <th v-for="key in columns"
                :style="key.style"
                @click="sortBy(key)"
                class="text-center active"
                :class="{info:sortKey == key.name}">

                {{ key.column }}
                <span
                        v-if="isArrowVisible(key.name)"
                        class="fa fa-fw" :class="sortOrders[key.name] > 0 ?
                            'fa-long-arrow-down' : 'fa-long-arrow-up'">
                    </span>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="entry in filteredData">
            <td v-for="key in columns" :class="key.class" :style="key.style">

                <span v-if="isIncludeEdit(key) ? false : true">{{render(entry,key)}}</span>

                <!-- whole input -->
                <div v-if="isIncludeEdit(key)">
                    <!-- checkbox -->
                    <input v-if="key.itype== 'selector'" type="checkbox" v-model="entry[key.bind]"/>

                    <!-- plain text -->
                    <input type="text" class="form-control"
                           v-if="key.itype == 'text'"
                           v-model="entry[key.bind]">

                    <textarea class="form-control"
                           v-if="key.itype == 'textarea'"
                              v-model="entry[key.bind]"></textarea>

                    <!-- dropdown -->
                    <select v-model="entry[key.bind]" v-if="key.itype == 'dropdown'" class="form-control" >
                        <option value="">--SELECT--</option>
                        <option v-for="lookup in lookups[key.selection]" :value="lookup.code">{{lookup.name}}</option>
                    </select>

                    <!-- date -->
                </div>

                <div v-if="key.name=='action'" class="btn-group">
                    <button type="button"
                            class="btn btn-primary dropdown-toggle btn-sm"
                            data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        Action <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" >
                        <li v-for="action in actionButtons"><a href="#" @click='actionTrigger(action,entry["id"])'>{{action.name}}</a></li>
                    </ul>
                </div>
                <div v-if="key.name=='$markDelete'" class='text-center' @click='actionTrigger("delete",entry["id"])'>
                    <button class="btn btn-danger btn-xs" type="button"><i class="fa fa-close"></i></button>
                </div>
            </td>
        </tr>
        </tbody>
        <tfoot>
        <tr  class="active">
            <th :colspan="totalColumn">
                <span class="label label-primary">Total Item: {{totalRows}}</span>
            </th>
        </tr>
        </tfoot>
    </table>
</template>

<script>
    export default {
        name: "grid",
        props: ['data','columns','filterKey','actions','default','lookups'],
        data() {

            let sortOrders = {};
            let sortKey = "";
            let that = this;

            this.columns.forEach((key) => {
                sortOrders[key.name] = 1;
                if(key.default !== undefined && key.default == true) {
                    sortKey = key.name;
                }
            });

            return {
                sortKey: sortKey,
                editVisible: false,
                sortOrders: sortOrders
            }
        },
        mounted() {

        },
        filters: {
            dynamicFilter() {

            }
        },
        computed: {
            filteredData() {
                let sortKey = this.sortKey;
                let data = this.data;

                let order = this.sortOrders[sortKey] || 1
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
            actionButtons() {
                return this.actions;
            },
            totalColumn() {
                return this.columns.length;
            },
            totalRows() {
                let rowData = this.data || [];
                return rowData.length;
            }
        },
        methods: {
            sortBy: function(key) {
                if(key.static) return false;
                this.sortKey = key.name;
                this.sortOrders[key.name] = this.sortOrders[key.name] * -1;
            },
            render: function(entry,key) {
                //check pipe period_start|period_end
                let keypos = key.name.indexOf("|"),
                    glue = key.glue || "-",
                    value = "";

                if(keypos >= 0) {
                    let names = key.name.split('|');
                    for(var i=0;i < names.length; i++) {
                        if(key.dtype == 'date') {
                            entry[names[i]] = moment(entry[names[i]]).format('L');
                        }
                        value += entry[names[i]] + glue;
                    }
                    value = value.substring(0,value.length -1);
                    key.dtype = "";
                }
                else {
                    value = entry[key.name];
                }

                if(key.dtype == 'date') {
                    return moment(value).format('L');
                }
                else if(key.dtype == 'currency') {
                    return accounting.formatNumber(value) + " QR";
                }
                else {
                    return value;
                }
            },
            actionTrigger: function(action,id) {
                this.$emit('action',action,id);
            },
            isArrowVisible(name) {
                return this.sortKey === name;
            },
            isIncludeEdit(key) {
                return (key.editable && !key.static);
            },
            inputTypeIs(type) {
                return this.inputType == type;
            },
            enableEdit(e) {
                console.log(this.$refs[e]);
            }
        }
    }
</script>