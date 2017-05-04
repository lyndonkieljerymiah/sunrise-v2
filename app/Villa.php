<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Villa extends BaseModel
{
    protected $custSelectionKeys = ["villa_class","status","location"];

    protected $table = 'villas';


    public static function createInstance() {
        return new Villa();
    }

    public function __construct(array $attributes = [])
    {

        $this->location = "sv1";
        $this->villa_no = "";
        $this->electricity_no = "";
        $this->water_no = "";
        $this->qtel_no = "";
        $this->description = "";
        $this->capacity = "0";
        $this->villa_class = "ff";
        $this->rate_per_month = "0.00";

        parent::__construct($attributes);
    }


    public function villaGalleries() {

        return $this->hasMany(VillaGallery::class);
    }
    
    
    //*******************mutator****************************

    protected function getFullRatePerMonthAttribute() {
       
        return $this->attributes['full_rate_per_month'] = number_format($this->rate_per_month,2)." ".env("CURRENCY_FORMAT");

    }

    /*************************************************************/
    public function vacantOnly() {
        return $this->where('status','vacant');
    }


    public function setToVacant() {
        $this->status = 'vacant';
        return $this;
    }

    public function setToOccupied() {
        $this->status = 'occupied';
        return $this;
    }
    
    public function getLists($pageNumber = 1,$pageSize = 20) {

        return DB::table('villas')->select(
            'id','created_at',
            DB::raw('(SELECT name FROM selections WHERE code = villas.location) AS location'),
            'villa_no',
            DB::raw('(SELECT name FROM selections WHERE code = villas.villa_class) AS villa_class'),
            'electricity_no',
            'water_no','qtel_no','rate_per_month',
            DB::raw('(SELECT name FROM selections WHERE code = villas.status) AS status'))->where('is_active',1)->get();
    }

}
