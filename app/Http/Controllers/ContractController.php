<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\Result;

class ContractController extends Controller
{
    protected $contracts;
    
    protected $selections;

    
    const DEFAULT_PERIOD = 12;

    public function __construct(
        \App\Repositories\ContractRepository $contracts,
        \App\Repositories\SelectionRepository $selections) {
        
        $this->contracts = $contracts;

        $this->selections = $selections;

        

    }

    public function index($status = "") {
        
        return $this->contracts->getContracts($status);
        
    }

    public function create()  {
        try {

            $outputs = array();

            event(new \App\Events\Contract\OnInitialize($outputs));

            return [
                "data"      => $this->contracts->create(self::DEFAULT_PERIOD),
                "villas"    => $outputs['villa'],
                "tenant"    => $outputs['tenant'],
                "lookups"   => $this->selections->getSelections(["contract_type","tenant_type"])
            ];
        }
        catch(Exception $e) {

            return abort($e->getMessage());
        }
    }

    public function recalculate() {

        
    }

     public function store(ContractForm $request) {

        try {
            $expectedOutput = array();
            event(new \App\Events\Contracts\OnCreating([
                'tenant'    => $request->input('tenant'),
                'villaId'   => $request->input('villa_id')
                ],$expectedOutput));
            
            $contractModel = $request->input('contract');

            $contractModel['tenant_id'] = $expectedOutput['tenant'];
            
            $contractModel['villa_no']  = $expectedOutput['villa'];

            $this->contracts->saveContract($contractModel);
                
            //trigger event since saving
            event(new \App\Events\Contracts\NotifyUpdate([
                    'villa' => ["villaId" => $request->input('villa_id'), "status" => "occupied"] 
                ]));
            
        }
        catch(Exception $e) {
            abort("500", $e->getMessage());
        }

        return Result::ok("Successfully save!!!");
    }

    public function renew($id) {

        //check fully paid
        //code here...

        //get the current contract
        $model = $this->contracts->single($id);
        
        $model->toDefaultPeriod(Carbon::now(),$this->DEFAULT_PERIOD);

        $villa = $this->villas->single($model->villa_id);
        
        $model->toComputeAmount($villa->rate_per_month);

        return $model;
        
    }

    
    public function update(ContactForm $request) {
        try {

            //check fully paid
            //code here...
            $this->contracts->renew($request->all());

        }
        catch(Exception $e) {
            
            return ["isOk" => false, "errors" => [$e->getMessages()]];

        }
        
        return Result::ok("Successfully update!!!");

    }

    public function cancelled(Request $request) {
        try {

            $this->contracts->cancelled(request()->all());
        }
        catch(Exception $e) {

        }

        return Result::ok('Succefully cancelled!!!');
    }


    public function terminate(Request $request,$id) {

        try {
            
            $model = $this->contracts->single($id);
            
            $model->terminate();
            
            $model->save();

            //trigger event since saving
            event(new \App\Events\OnContractCreated(['villa' =>
                    [
                        "villaId" => $request->input('villa_id'),
                        "status" => "occupied"
                    ]
            ]));
          
        }
        catch(Exception $e) {
            return ["isOk" => false, "errors" => [$e->getMessages()]];
        }

    }

    protected function registerTenant($inputs) {

        return $this->tenant->attach($inputs)->getLastRecord();
        
    }
    

}
