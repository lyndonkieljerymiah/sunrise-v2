<?php

namespace App;

use Carbon\Carbon;

class Contract extends BaseModel
{

    const PENDING = 'pending';
    const ACTIVE = 'active';
    const COMPLETED = 'completed';
    const CANCELLED = 'cancelled';

    protected $table = "contracts";

    protected $appends = ['full_status','full_contract_type','payable_per_month','full_period_start','full_period_end'];

    //factory method
    public static function createInstance($defaultMonths) {

        $contract = new Contract();

        $contract->contract_type = "legalized";

        $contract->tenant_id = 0;

        $contract->villa_id = 0;

        $contract->setDefaultPeriod(Carbon::now(),$defaultMonths);

        $contract->amount = 0;

        $contract->register_tenant = Tenant::createInstance();

        $contract->villa_list = Villa::with('villaGalleries')
            ->where('status','vacant')
            ->get();

        return $contract;
    }

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

    protected function getFullPeriodStartAttribute() {
        return $this->attributes['full_period_start'] = Carbon::parse($this->period_start)->toDateTimeString();
    }

    protected function getFullPeriodEndAttribute() {
        return $this->attributes['full_period_end'] = Carbon::parse($this->period_end)->toDateTimeString();
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

    public function searchByNo($contractNo) {

        return $this->where('contract_no',$contractNo);

    }

    public function getContracts($status = "") {

          $contracts = \DB::table('contracts')
                        ->join('tenants', 'contracts.tenant_id', '=','tenants.id')
                        ->join('villas', 'contracts.villa_id','=','villas.id')
                        ->select('contracts.id', 'contracts.created_at',
                            'contract_no',
                            \DB::raw('(SELECT name FROM selections WHERE code=contracts.contract_type) AS contract_type'),
                            \DB::raw('DATE_FORMAT(period_start,"%m/%d/%Y") AS period_start'),
                            \DB::raw('DATE_FORMAT(period_end,"%m/%d/%Y") AS period_end'),
                            'tenants.full_name',
                            'villas.villa_no',
                            'amount',
                            \DB::raw('(SELECT name FROM selections WHERE code=contracts.status) AS status'));

        if($status != "") 
            $contracts->where('contracts.status',$status);

        return $contracts->get();

    }

    public function withAssociates() {
        
        return $this->with('villa')->with('tenant');

    }
   
    public function setDefaultPeriod(Carbon $startPeriod, $default,$extraPeriod = 0) {

        $this->period_start = $startPeriod->addDays($extraPeriod)->toDateTimeString();
        $this->period_end = Carbon::parse($this->period_start);
        $this->period_end = $this->period_end->addMonth($default)->toDateTimeString();


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

    public function saveContract($entity) {

        $villaNo = $entity['villa_no'];

        unset($entity['villa_no']);

        $entity['contract_no'] = "C".$villaNo."-".Carbon::now()->year."-".$this->createNewId();

        $this->toMap($entity);

        $this->pending()->save();

        return $this;
    }

    public function pending() {
        $this->status = "pending";
        return $this;
    }

    public function terminate() {

        $this->status = "terminated";
        return $this;
    }

    public function cancel() {

        $this->status = "cancelled";

        return $this;
    }

    public function completed() {
        $this->status = "completed";
        return $this;
    }

    public function active() {
        $this->status = "active";

        return $this;
    }

    public function isActive() {
        return $this->hasStatusOf('active');
    }

    public function isPending() {
        return $this->hasStatusOf('pending');
    }

    public function hasNoBalance() {

        //got to bill

    }

    public function getRemainingPeriod() {
        $endPeriod = Carbon::parse($this->period_end);
        $remaining = $endPeriod->diffInDays(Carbon::now());

        return $remaining;
    }

}
