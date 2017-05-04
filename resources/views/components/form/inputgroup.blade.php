$labelClass = isset($labelClass) ? : $labelClass : "col-md-3";
{{Form::label($name,$text )}}
<label for="$name"  ['class' => $labelClass] >$text</label>
<div class="col-md-9">
    <input name="$name" type="$type" class="form-control" v-model="$vmodel" />
</div>
