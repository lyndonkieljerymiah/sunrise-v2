<?php

namespace App;

use Carbon\Carbon;

class Contract extends BaseModel
{

    const PENDING = 'pending';
    const ACTIVE = 'active';
    const COMPLETED = 'completed';
    const CANCELLED = 'cancelled';

    //
    

    protected $table = "contracts";

    protected $appends = ['full_status','full_contract_type','payable_per_month'];

    protected function getFullStatusAttribute() {

        return $this->attributes['full_status'] = Selection::convertCode($this->status);

    }

    protected function getFullContractTypeAttribute() {

        return $this->attributes['contract_type'] = Selection::convertCode($this->contract_type);
    }

    protected function getPayablePerMonthAttribute() {

        if($this->amount > 0) {
            $totalDays = Carbon::parse($this->period_start)->diffInDays(Carbon::parse($this->period_end));

            $totalAmountPerDays = $this->amount / intval($totalDays / 30);

            return $this->attributes['payable_per_month'] = $totalAmountPerDays;
        }
        return 0;
    }

    public function contractTermination() {
        
        return $this->hasMany(ContractTermination::class);
    }

    public function villa() {
        return $this->hasOne(Villa::class,"id","villa_id");
    }

    public function tenant() {
        return $this->hasOne(Tenant::class,"id","tenant_id");
    }


    public static function createInstance($defaultMonths) {
        
        $contract = new Contract();
        
        $contract->contract_type = "legalized";

        $contract->tenant_id = 0;

        $contract->villa_id = 0;

        $contract->toDefaultPeriod(Carbon::now()->toDateTimeString(),$defaultMonths);

        $contract->amount = 0;

        $contract->register_tenant = Tenant::createInstance();

        $contract->villa_list = Villa::with('villaGalleries')->where('status','vacant')->get();

        return $contract;
    }


    
    public function lists($status = "") {

          $contracts = \DB::table('contracts')
                        ->join('tenants', 'contracts.tenant_id', '=','tenants.id')
                        ->join('villas', 'contracts.villa_id','=','villas.id')
                        ->select('contracts.created_at', 
                            'contract_no',
                            \DB::raw('(SELECT name FROM selections WHERE code=contracts.contract_type) AS contract_type'),
                            'period_start','period_end',
                            'tenants.full_name',
                            'villas.villa_no',
                            \DB::raw('(SELECT name FROM selections WHERE code=contracts.status) AS status'));

        if($status != "") 
            $contracts->where('contracts.status',$status);

        return $contracts->get();

    }

    public function withAssociates() {
        
        $this->with('villa')->with('tenant');

        return $this;

    }
   
    public function toDefaultPeriod($startPeriod,$default) {

        $this->period_start = $startPeriod;

        $this->period_end = Carbon::now()->addMonths($default)->toDateTimeString();

    }

    public function setPeriod($periodStart,$periodEnd) {
        $this->period_start = $periodStart;
        $this->period_end = $periodEnd;
    }

    public function toComputeAmount($rate) {
        
        $totalPeriod = Carbon::parse($this->period_start)->diffInDays(Carbon::parse($this->period_end));

        $totalMonth = intval($totalPeriod / 30);

        $this->amount = $rate * $totalMonth;

    }

    public function terminate() {

        $this->status = "terminated";
    }

    public function cancel() {

        $this->status = "cancelled";
    }

    public function completed() {
        $this->status = "completed";
    }

    

}
