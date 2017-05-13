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
                                <select name="location" v-model="model.location" class="form-control">
                                    <option v-for="lookup in lookups.villa_location"
                                        v-bind:value="lookup.code" >{{lookup.name}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="villa_no" class="col-md-2 text-right">Villa No:</label>
                            <div class="col-md-10">
                                <input name="villa_no" type="text" class="form-control" v-model="model.villa_no" >
                                <strong class="text-danger text-small" v-text="errors.get('villa_no')"></strong>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-md-2 text-right">Description:</label>
                            <div class="col-md-10">
                                <textarea name="description" rows="5" class="form-control" v-model="model.description"></textarea>
                                <strong class="text-danger text-small" v-text="errors.get('description')"></strong>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="electricity_no" class="col-md-2 text-right">Electrity No:</label>
                            <div class="col-md-4">
                                <input name="electricity_no" type="text" class="form-control" v-model="model.electricity_no">
                                <strong class="text-danger text-small" v-text="errors.get('electricity_no')"></strong>
                            </div>

                            <label for="water_no" class="col-md-2 text-right">Water No:</label>
                            <div class="col-md-4">
                                <input name="water_no" type="text" class="form-control" v-model="model.water_no">
                                <strong class="text-danger text-small" v-text="errors.get('water_no')"></strong>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="qtel_no" class="col-md-2 text-right">QTel No:</label>
                            <div class="col-md-4">
                                <input name="qtel_no" type="text" class="form-control" v-model="model.qtel_no">
                                <strong class="text-danger text-small" v-text="errors.get('qtel_no')"></strong>
                            </div>

                            <label for="capacity" class="col-md-2 text-right" >Capacity:</label>
                            <div class="col-md-4">
                                <input name="capacity" type="number" class="form-control" v-model="model.capacity">
                                <strong class="text-danger text-small" v-text="errors.get('capacity')"></strong>
                              </div>
                        </div>

                        <div class="form-group">
                            <label for="rate_per_month" class="col-md-2 text-right">Rate per Month:</label>
                            <div class="col-md-4">
                                <input name="rate_per_month" type="text" class="form-control" v-model="model.rate_per_month">
                                <strong class="text-danger text-small" v-text="errors.get('rate_per_month')"></strong>
                            </div>

                            <label for="villa_class" class="col-md-2 text-right">Villa Class:</label>
                            <div class="col-md-4">
                                <select name="villa_class" v-model="model.villa_class" class="form-control">
                                    <option v-for="lookup in lookups.villa_type" v-bind:value="lookup.code">{{lookup.name}}</option>
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
                        :data="computedGalleries"
                        :columns="gridColumns">

                        </grid-view>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <slider :slides="model.villa_galleries"></slider>
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
                btnDisabled: false,
                model: {},
                galleries: [],
                errors: ErrorValidations.newInstance(),
                lookups: [],
                gridColumns: [
                    {name: 'image_name', column: 'Image Name', static:true, style:'width:10%'},
                    {name: 'mime_type', column: 'Mime Type', static:true},
                    {name: '$markDelete', column:'', static:true, style:'width:5%;text-align:center'}
                ]
            }
        },
        methods: {
            onSave() {
                var $this = this;
                var formData = new FormData();
                //append to formdata
                Object.keys(this.model).forEach(key => {
                    if(key == 'villa_galleries') {
                        $this.model.villa_galleries.forEach(item => {
                            if(item.markDelete !== undefined)
                                formData.append('markDeleted[]',item.markDelete);
                        });
                    }
                    else {
                        formData.append(key,$this.model[key]);
                    }
                });

                //check galleries
                if(this.galleries.length > 0) {
                    this.galleries.forEach(item => {
                        formData.append('galleries[]',item);
                    });
                }

                AjaxRequest
                    .postMultiForm('villa',this.operationType,formData)
                    .done(response => {toastr.success(response.data.message);})
                    .fail(response => {
                        if(response.status === 422) {
                            $this.errors.register(response.responseJSON);
                        }
                    });
            },
            onDispatch(file) {
                if(file)  {
                    this.galleries.push(file.file);
                }
            }
        },
        mounted() {

            var $this = this;
            //create initialize

            AjaxRequest.get('villa',this.formAction)
                .then(response => {
                    $this.model = response.data.data;
                    $this.lookups = response.data.lookups;
                });
        },
        computed: {
            computedGalleries: function() {

                return this.model.villa_galleries == undefined ? [] : this.model.villa_galleries;
            },

        }

    }
</script>
