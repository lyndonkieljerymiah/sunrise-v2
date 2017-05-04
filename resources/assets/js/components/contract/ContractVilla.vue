<template>
  <div id="ContractVilla" class="row">
    <div class="panel panel-primary">
      <div class="panel-heading text-center">
        <i class="fa fa-home fa-lg" aria-hidden="true"></i> VILLA DETAILS
      </div>
      <div class="panel-body">
        <div class="col-md-12" style="margin-bottom: 10px">
          <select class="form-control" @change="selected()" v-model="contract.data.villa_id">
            <option value="0" selected="true">--SELECT VILLA--</option>
            <option v-for="villa in contract.data.villa_list" :value="villa.id">{{ villa.villa_no }}</option>
          </select>
          <error :errorDisplay="contract.errors.get('villa_id')">{{contract.errors.get('villa_id')}}</error>
        </div>
        <div class="col-md-7">
          <div class="panel panel-primary">
            <div class="panel-body" style="padding-left:0px; padding-right:0px;">
                <slider :slides="villaobject.villa_galleries"></slider>
            </div>
          </div>
        </div>

        <div class="col-md-5">
          <div class="col-md-12">
            <p>Details:<strong> {{ villaobject.description }}</strong></p>
            <p>Villa Class:<strong> {{ villaobject.villa_class }} </strong></p>
            <p>Rate per Month: <strong> {{ villaobject.rate_per_month }} </strong></p>
            <p>Status: <strong> {{ villaobject.status }} </strong></p>
          </div>
      </div>
    </div>
  </div>



</div>
</template>

<script>
import Slider from '../Slider.vue';
import ErrorLabel from '../ErrorLabel.vue';

export default {


  name: "ContractVilla",
  props: ['contract'],
  components: {'slider': Slider,'error': ErrorLabel },
  data: function () {
    return {
      villa_id: "",
      villa_obj:{},
      galleries: []
    }
  },
  methods: {
    selected: function () {
      this.villa_obj = this.contract.select();
      this.contract.recal();
    },
    get: function (name){
      return this.villa_obj[0] === undefined ? '' : this.villa_obj[0][name];

    }
  },
  computed: {
    villaobject() {
      if(this.contract.selected !== undefined)
        return this.contract.selected;

    }
  }

}

</script>
