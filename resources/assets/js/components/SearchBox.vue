<template>
    <form class="form-inline" @submit.prevent="onClickSearch">
        <div class="form-group">
            <input  name="fieldSearch" type="text" class="form-control" placeholder="Search" v-model="searchField"/>
        </div>
        <div class="form-group">
            <button class="btn btn-info" type="submit">Search</button>
        </div>
    </form>
</template>

<script>
    export default {
        data() {
            return {
                searchField: ''
            }
        },
        methods: {
            onClickSearch: function() {
                console.log('emitting search');
                this.$emit("trigger",this.searchField);
            }
        }
    }
</script>