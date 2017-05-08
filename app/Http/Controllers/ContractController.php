<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Events\Contract\NotifyUpdate;
use App\Events\Contract\OnCreating;
use App\Events\Contract\OnRecalculate;
use App\Http\Requests\ContractRegisterForm;
use App\Selection;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Services\Result;

class ContractController extends Controller
{
    protected $contracts;
    
    protected $selections;

    
    const DEFAULT_PERIOD = 12;

    public function __construct() {
        
        $this->contracts = new Contract();
        $this->selections = new Selection();

    }

    public function index() {

        return view("contract.contract");
    }

    public function create() {
        return view("contract.create");
    }

    public function apiList($status = "") {

        return $this->contracts->getContracts($status);
        
    }

    public function apiCreate()  {
        try {

            $outputs = array();

            return [
                "data"      => $this->contracts->createInstance(self::DEFAULT_PERIOD),
                "lookups"   => $this->selections->getSelections(["contract_type","tenant_type"])
            ];
        }
        catch(Exception $e) {

            return abort(500,$e->getMessage());

        }
    }

    public function apiRecalculate(Request $request) {

        $villaId = request()->input('villa_id');

        //get the selected villa object to get rate per month
        event(new OnRecalculate(["villaId" => $villaId],$expectedOutput));

        if(sizeof($expectedOutput)) {

            //get the rate
            $ratePerMonth = $expectedOutput['villa']->rate_per_month;

            //create contract with new rate
            $contract = $this->contracts->createInstance(self::DEFAULT_PERIOD);

            $contract->setPeriod($request->input('period_start'),
                                $request->input('period_end'));

            $contract->toComputeAmount($ratePerMonth);

            return $contract;
        }

        return Result::badRequest("No contract was created");

    }

     public function apiStore(ContractRegisterForm $request) {
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
            return Result::badRequest(['message' => $e->getMessage()]);
        }

        return Result::ok("Successfully save!!!",['id' => $contract->contract_no]);
    }

    public function apiRenew($id) {

        if(!$this->contracts->hasStatusOf('active')) {

            return Result::badRequest(['message' => 'Contract is not active']);

        }

        //get the old contract including villa
        $contract = $this->contracts->withAssociates()->find($id);

        //display contract
        $contract->toDefaultPeriod(Carbon::now(),self::DEFAULT_PERIOD);

        return $contract;
        
    }

    
    public function apiUpdate(ContractRegisterForm $request) {
        try {

            $inputs = $request->filterInput();



        }
        catch(Exception $e) {
            
            return ["isOk" => false, "errors" => [$e->getMessages()]];

        }
        
        return Result::ok("Successfully update!!!");

    }

    public function apiCancel(Request $request) {
        try {
            
            $this->contracts
                ->find($request->input('id'))
                ->delete();
                
        }
        catch(Exception $e) {
            Result::badRequest(['message' => $e->getMessage()]);
        }

        return Result::ok('Succefully cancelled!!!');
    }


    public function apiTerminate(Request $request,$id) {

        try {
            
            $model = $this->contracts->find($id)
                        ->terminate()
                        ->save();

            //trigger event since saving
            event(new NotifyUpdate(['villa' =>
                    [
                        "villaId" => $request->input('villa_id'),
                        "status" => "vacant"
                    ]
            ]));
          
        }
        catch(Exception $e) {
            return Result::badRequest(['message' => $e->getMessage()]);
        }

        return Result::ok('Successfully Terminate contract');

    }


    

}
