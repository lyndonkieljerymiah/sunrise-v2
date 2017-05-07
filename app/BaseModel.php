<?php


namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {
    
    protected $guarded = ['id'];

    protected $custSelectionValues = array();

    protected function setField($field,$value) {
        if(!in_array($field,$this->appends)) {
            if(is_numeric($value)) {
                eval('$this->'. $field . "=" . $value . ";");
            }
            else {
                eval('$this->'. $field . "=\"" . $value . "\";");
            }
        }
    }

    protected function explodeSelection() {
        
        foreach($this->custSelectionKeys as $value)  {
            eval('$result = $this->'.$value.';');
            $data[] = $result;
        }

        $result = Selection::getValues($data);
        
        for($i=0; $i < sizeof($result); $i++) {
            $this->custSelectionValues[$result[$i]["category"]] = $result[$i]["name"];
        }

        return $this->custSelectionValues;
    }

    public function hasStatusOf($status) {
        $this->status = $status;
    }

    public function toMap($fields = array()) {
        if(sizeof($fields) > 0) {
            foreach ($fields as $key => $value) {
                //do not include custom attribute
                if(!in_array($key,$this->appends)) {
                    $this->setField($key,$value);
                }
            }
        }

        return $this;
    }

    public function toSave($isUserInclude = false) {

        //update save
        $this->created_at = Carbon::now();
        $this->updated_at = Carbon::now();

        return $this->save();
    }

    //chaining
    public function explicitSearch($fieldKey,$fieldValue) {
        return $this->where($fieldKey,$fieldValue);
    }

    public function createNewId() {

        $lastRecord = $this->orderBy('id','desc')->first();

        if($lastRecord == null)
            return 1;

        return $lastRecord->id++;
    }

    public function getId() {
        return $this->id;
    }

}