<template>
    <div v-show="errorDisplay" class="help-block alert alert-danger">
        <span><i class="fa fa-times-rectangle"></i> <small><slot></slot></small></span>
    </div>
</template>

<script>
    export default {
        props: {
            errorDisplay: false,
            errorText: ''
        }
    }
</script>