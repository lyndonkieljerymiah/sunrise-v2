<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ContractBill extends BaseModel
{
    
    public function Payments() {

        $this->hasMany(Payment::class,'bill_id','id');
    }

    public static function createInstance($contractId) {

        $bill = new ContractBill();
        $bill->contract_id = $contractId;
        $bill->status = "pending";
        $bill->instance = Payment::createInstance();
        $bill->payments = [];

        return $bill;
    }




}
