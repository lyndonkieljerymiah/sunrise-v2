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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</template>

<script>
    export default {
        name: "modal",
        props: {
            dialogTitle: '',
            size: '',
            modalType: 'custom'
        },
        methods: {
            show() {
                alert("hello world");
            }
        },
        mounted() {
            var that = this;
            VueEvent.$on('onModalActive',() => {
               $("#modalComponent").modal({show:true});
            })
        }
    }
</script>
<style>
    .temp-modal {display:none}
</style>