<?php

namespace App\Http\Controllers;

use App\Events\Contract\OnCreating;
use App\Events\Contract\OnRecalculate;
use App\Http\Requests\ContractRegisterForm;
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

            return [
                "data"      => $this->contracts->create(self::DEFAULT_PERIOD),
                "lookups"   => $this->selections->getSelections(["contract_type","tenant_type"])
            ];
        }
        catch(Exception $e) {

            return abort($e->getMessage());
        }
    }

    public function recalculate($villaId) {

        //get the selected villa object to get rate per month
        event(new OnRecalculate(["villaId" => $villaId],$expectedOutput));

        if(sizeof($expectedOutput)) {

            //get the rate
            $ratePerMonth = $expectedOutput['villa']->rate_per_month;

            //create contract with new rate
            $contract = $this->contracts->create(self::DEFAULT_PERIOD);
            $contract->toComputeAmount($ratePerMonth);

            return $contract;
        }

        return Result::badRequest("No contract was created");

    }

     public function store(ContractRegisterForm $request) {

        try {
            dd($request->all());

            $expectedOutput = array();

            event(new OnCreating([
                'tenant'    => $request->input('register_tenant'),
                'villaId'   => $request->input('villa_id')
                ],$expectedOutput));
            
            $contractModel = $request->input('contract');

            $contractModel['tenant_id'] = $expectedOutput['tenant']->tenant_id;
            
            $contractModel['villa_no']  = $expectedOutput['villa']->villa_no;

            $this->contracts->saveContract($contractModel);
            
            //trigger event since saving
            event(new \App\Events\Contracts\NotifyUpdate([
                    'villa' => ["villaId" => $request->input('villa_id'), "status" => "occupied"] 
                ]));
            
        }
        catch(Exception $e) {
            abort(500, $e->getMessage());
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


    

}
