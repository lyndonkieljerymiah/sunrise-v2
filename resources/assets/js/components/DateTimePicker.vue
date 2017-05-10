<template>
    <div class='input-group date' ref="$dtPicker">
        <input type='text' class="form-control" name="dpName" :value="value" :readonly="disabled"/>
        <span class="input-group-addon">
            <span class="fa fa-calendar"></span>
        </span>
    </div>
</template>

<script>
    export default {
        props:{
            dpName: "",
            value: "",
            disabled: false,
            dpformat: 'L'
        },
        mounted() {
            let dtPicker = this.$refs.$dtPicker;
            let input = $(dtPicker).children('input');

            var dpformat = (this.dpformat === undefined) ? 'L' : this.dpformat;

            $(dtPicker).datetimepicker({format: dpformat}).on('dp.change',(e) => {
                console.log(e.date);
                this.onChange(e.date.format(dpformat));
            });

            input.on('change',(e) => {
               console.log($(this).val());
            });


        },
        methods: {
            onChange(dtValue) {
                this.$emit('pick',this.dpName,dtValue);
            }
        }


    }

</script>

