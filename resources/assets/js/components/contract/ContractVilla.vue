<template>
  <div class="ContractVilla">


<div class="col-md-7">
  <div class="panel panel-primary">
    <div class="panel-heading "><center><i class="fa fa-home fa-lg" aria-hidden="true"></i> VILLA DETAILS</center></div>
    <div class="panel-body" style="padding-left:0px; padding-right:0px;">

      <div class="col-md-7">
      <div class="panel panel-primary">
        <div class="panel-body" style="padding-left:0px; padding-right:0px;">
            <slider :slides="get('villa_galleries')"></slider>
        </div>
      </div>
    </div>

    <div class="col-md-5">
      <div class="col-md-12">
        <select class="form-control" @change="selected()" v-model="villa_id">
          <option v-for="villa in villas" :value="villa.id">{{ villa.villa_no }}</option>
        </select>
      </div>

      <div class="col-md-12">
        <br/>
        <p>Details:<strong> {{ get('description')}}</strong></p>
        <p>Rate per Month: <strong> {{ get('full_rate_per_month')}} </strong></p>
        <p>Villa Class:<strong> {{ get('full_villa_class')}} </strong></p>
        <p>Status: <strong> {{ get('full_status')}} </strong></p>
        <p>Status: <strong> {{ get('villa_id')}} </strong></p>
      </div>
    </div>

  </div>
  </div>
</div>


</div>
</template>

<script>
import Slider from '../Slider.vue';
export default {


  name: "ContractVilla",
  props: ['villas'],
  components: {'slider': Slider },
  data: function () {
    return {
      villa_id: "",
      villa_obj:{},
      galleries: []
    }
  },
  methods: {
    selected: function () {
      var $this = this;
      var v=this.villas.filter(function(i) {
        return i['id'] == $this.villa_id;
      });
      this.villa_obj = v;
    },
    get: function (name){
      return this.villa_obj[0] === undefined ? '' : this.villa_obj[0][name];

    }
  }

}

</script>
