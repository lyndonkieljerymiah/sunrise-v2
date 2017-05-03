<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ContractBill extends BaseModel
{

    const DEFAULT_PERIOD = 1;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->created_at = Carbon::now();
        $this->updated_at = Carbon::now();
    }

    public function Payments() {

        $this->hasMany(Payment::class,'bill_id','id');
    }

    public static function createInstance($contractId) {

        $bill = new ContractBill();
        $bill->contract_id = $contractId;
        $bill->status = "pending";
        $bill->instance = Payment::createInstance();
        $bill->instance->initPeriod(self::DEFAULT_PERIOD);
        $bill->payments = [];

        return $bill;
    }






}
