<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Payment extends BaseModel
{
    //


    public function initPeriod($defaultMonth = 12) {

        $this->period_start = Carbon::now()->toDateTimeString();

        $this->period_end = Carbon::now()->addMonth($defaultMonth)->toDateTimeString();

        return $this;
    }

    public static function createInstance() {
        $p = new Payment([
            "effectivity_date"      =>  Carbon::now()->toDateTimeString(),
            "payment_type"          =>  "cheque",
            "payment_mode"          =>  "payment",
            "payment_no"            =>  "",
            "bank"                  =>  "",
            "amount"                =>  "0.00",
            "remarks"               =>  ""]);

        $p->initPeriod();

        return $p;

    }


}
