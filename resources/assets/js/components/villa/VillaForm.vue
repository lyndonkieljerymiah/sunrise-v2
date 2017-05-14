<template>
<div>
    <form id="frmVillaEntry" @submit.prevent="onSave" class="form-horizontal" enctype="multipart/form-data" @keydown="errors.clear($event.target.name)">
        <div class="form-group">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="location" class="col-md-2 text-right">Location:</label>
                            <div class="col-md-10">
                                <select name="location" v-model="viewModel.data.villa.location" class="form-control">
                                    <option v-for="lookup in viewModel.lookups.villa_location"
                                        v-bind:value="lookup.code" >{{lookup.name}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="villa_no" class="col-md-2 text-right">Villa No:</label>
                            <div class="col-md-10">
                                <input name="villa_no" type="text" class="form-control" v-model="viewModel.data.villa.villa_no" >
                                <strong class="text-danger text-small" v-text="viewModel.errors.get('villa_no')"></strong>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-md-2 text-right">Description:</label>
                            <div class="col-md-10">
                                <textarea name="description" rows="5" class="form-control" v-model="viewModel.data.villa.description"></textarea>
                                <strong class="text-danger text-small" v-text="viewModel.errors.get('description')"></strong>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="electricity_no" class="col-md-2 text-right">Electrity No:</label>
                            <div class="col-md-4">
                                <input name="electricity_no" type="text" class="form-control" v-model="viewModel.data.villa.electricity_no">
                                <strong class="text-danger text-small" v-text="viewModel.errors.get('electricity_no')"></strong>
                            </div>

                            <label for="water_no" class="col-md-2 text-right">Water No:</label>
                            <div class="col-md-4">
                                <input name="water_no" type="text" class="form-control" v-model="viewModel.data.villa.water_no">
                                <strong class="text-danger text-small" v-text="viewModel.errors.get('water_no')"></strong>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="qtel_no" class="col-md-2 text-right">QTel No:</label>
                            <div class="col-md-4">
                                <input name="qtel_no" type="text" class="form-control" v-model="viewModel.data.villa.qtel_no">
                                <strong class="text-danger text-small" v-text="viewModel.errors.get('qtel_no')"></strong>
                            </div>

                            <label for="capacity" class="col-md-2 text-right" >Capacity:</label>
                            <div class="col-md-4">
                                <input name="capacity" type="number" class="form-control" v-model="viewModel.data.villa.capacity">
                                <strong class="text-danger text-small" v-text="viewModel.errors.get('capacity')"></strong>
                              </div>
                        </div>

                        <div class="form-group">
                            <label for="rate_per_month" class="col-md-2 text-right">Rate per Month:</label>
                            <div class="col-md-4">
                                <input name="rate_per_month" type="text" class="form-control" v-model="viewModel.data.villa.rate_per_month">
                                <strong class="text-danger text-small" v-text="viewModel.errors.get('rate_per_month')"></strong>
                            </div>

                            <label for="villa_class" class="col-md-2 text-right">Villa Class:</label>
                            <div class="col-md-4">
                                <select name="villa_class" v-model="viewModel.data.villa.villa_class" class="form-control">
                                    <option v-for="lookup in viewModel.lookups.villa_type" v-bind:value="lookup.code">{{lookup.name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <button class="btn btn-info btn-block" :disabled="btnDisabled" type="submit">Save</button>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <image-upload @dispatch="onDispatch"></image-upload>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                         <grid-view
                        :data="viewModel.data.villa.villa_galleries"
                        :columns="gridColumns"
                        @action="onDelete"
                         >
                        </grid-view>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <slider :slides="viewModel.data.villa.villa_galleries"></slider>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
</template>

<script>

    import ImageUpload from '../ImageUpload.vue';
    import GridView from '../GridView.vue';
    import Slider from '../Slider.vue';

    import {VillaEntryViewModel} from './VillaViewModel';

    export default {
        props: {
            formAction: {required:true},
            operationType: {required:true}
        },
        components: {
            'imageUpload': ImageUpload,
            'gridView': GridView,
            'slider': Slider
        },
        data() {
            return {
                viewModel: new VillaEntryViewModel(),
                btnDisabled: false,
                gridColumns: [
                    {name: 'image_name', column: 'Image Name', static:true, style:'width:10%'},
                    {name: 'mime_type', column: 'Mime Type', static:true},
                    {name: 'delete_mark', column:'', style:'width:5%;text-align:center',editable:true,bind:'delete_mark',itype:'selector' }
                ]
            }
        },
        methods: {
            onSave() {
                this.viewModel.save(this.operationType);
            },
            onDispatch(file) {
                if(file)  {
                    this.viewModel.insert(file.file);
                }
            },
            onDelete(a,id) {
                this.viewModel.remove(id);
            }
        },
        mounted() {
            //create initialize
            this.viewModel.create(this.formAction);
        }
    }
</script>
