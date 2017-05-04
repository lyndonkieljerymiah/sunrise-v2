<template>
    <div id="modalComponent" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{dialogTitle}}</h4>
                </div>
                <div class="modal-body">
                    <slot></slot>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"  @click="dismiss(false)">Close</button>
                    <button type="button" class="btn btn-primary" @click="dismiss(true)">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "modal",
        props: {
            dialogTitle: '',
            size: '',
            modalType: 'custom',
            isClose: false
        },
        methods: {
            dismiss(result) {
                //$("#modalComponent").modal('hide');
                this.$emit("dismiss",result);
            }
        },
        mounted() {
            VueEvent.$on('onModalActive',() => {
               //show
               $("#modalComponent").modal({show:true});
            })
        }
    }
</script>
<style>
    .temp-modal {display:none}
</style>