<?php

namespace App\Http\Controllers;

use App\Events\Contract\NotifyUpdate;
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

            return abort(500,$e->getMessage());
        }
    }

    public function recalculate(Request $request) {

        $villaId = request()->input('villa_id');

        //get the selected villa object to get rate per month
        event(new OnRecalculate(["villaId" => $villaId],$expectedOutput));

        if(sizeof($expectedOutput)) {
            //get the rate
            $ratePerMonth = $expectedOutput['villa']->rate_per_month;

            //create contract with new rate
            $contract = $this->contracts->create(self::DEFAULT_PERIOD);
            $contract->setPeriod($request->input('period_start'),$request->input('period_end'));
            $contract->toComputeAmount($ratePerMonth);

            return $contract;
        }

        return Result::badRequest("No contract was created");

    }

     public function store(ContractRegisterForm $request) {
        try {

            $expectedOutput = array();

            $result = $request->filterInput();

            event(new OnCreating([
                'tenant'    => $result['register_tenant'],
                'villaId'   => $result['villa_id']
                ],$expectedOutput));

            //remove tenant
            unset($result['register_tenant']);

            $contractModel = $result;

            //temp manually add user id
            $contractModel['user_id'] = 1;

            $contractModel['tenant_id'] = $expectedOutput['tenant']->id;
            
            $contractModel['villa_no']  = $expectedOutput['villa']->villa_no;

            $contract = $this->contracts->saveContract($contractModel);
            
            //trigger event since saving
            event(new NotifyUpdate([
                    'villa' => ["id" => $result['villa_id'], "status" => "occupied"]
                ]));
        }
        catch(Exception $e) {
            abort(500, $e->getMessage());
        }

        return Result::ok("Successfully save!!!",['id' => $contract->id]);
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
