<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Villa extends BaseModel
{  

    protected $custSelectionKeys = ["villa_class","status","location"];

    protected $table = 'villas';

    public function villaGalleries() {

        return $this->hasMany(VillaGallery::class);
    }
    
    
    //*******************mutator****************************

    protected function getFullRatePerMonthAttribute() {
       
        return $this->attributes['full_rate_per_month'] = number_format($this->rate_per_month,2)." ".env("CURRENCY_FORMAT");

    }

    /*************************************************************/

    public function statusCount() {

        return \DB::table('villas')->select('status',\DB::raw('COUNT(id) as count'))->groupBy('status')->get();
    }

    public function setToVacant() {
        $this->status = 'vacant';
    }

    public function setToOccupied() {
        $this->status = 'occupied';
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
