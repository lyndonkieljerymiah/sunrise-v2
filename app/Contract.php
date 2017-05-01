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
    protected $appends = ["full_contract_type","full_status"];

    protected $table = "contracts";

    protected $custSelectionKeys = ["status","contract_type"];
    
    protected function getFullContractTypeAttribute() {
        
         //lazy loading
        if(sizeof($this->custSelectionValues) == 0) {

            $this->explodeSelection();

        }

        return $this->attributes["full_contract_type"] = isset($this->custSelectionValues["contract_type"]) ? $this->custSelectionValues["contract_type"] : ""; 
    }

    protected function getFullStatusAttribute() {
        //lazy loading
        if(sizeof($this->custSelectionValues) == 0) {
            $this->explodeSelection();
        }

        return $this->attributes["full_status"] = isset($this->custSelectionValues["contract_status"]) ? $this->custSelectionValues["contract_status"] : ""; $value;
    }

    public function contractTermination() {
        
        return $this->hasMany(ContractTermination::class);

    }

    public function createNewModel() {
        $newModel = new Contract();
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

    public function getAssociates() {
        
        $tenantId = $this->tenant_id;
        $villaId = $this->villa_id;

        $associates = [
            'tenant'    =>  \DB::table('tenants')->where('id',$tenantId)->first(),
            'villa'     =>  \DB::table('villas')->where('id',$villaId)->first()
        ];
        
        $this->associates = $associates;

        return $this;
    }
   
   
   
    public function toDefaultPeriod($startPeriod,$default) {

        $this->period_start = $startPeriod;

        $this->period_end = Carbon::now()->addMonths($default);

    }

    public function toComputeAmount($rate) {
        
        $totalPeriod = $this->period_start->diffInDays($this->period_end);

        $totalMonth = intval(ceil($totalPeriod / 30));

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
