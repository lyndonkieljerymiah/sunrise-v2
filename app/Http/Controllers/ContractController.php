<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Events\Contract\NotifyUpdate;
use App\Events\Contract\OnCreating;
use App\Events\Contract\OnRecalculate;
use App\Http\Requests\ContractRegisterForm;
use App\Http\Requests\RenewalForm;
use App\Selection;
use App\Services\Bundle;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Services\Result;
use Mockery\Exception;

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
        $bundle = new Bundle();
        $bundle->add("villaId",$villaId);

        event(new OnRecalculate($bundle));
        $villaOutput = $bundle->getOutput('villa');
        if($villaOutput != null) {
            //get the rate
            $ratePerMonth = $villaOutput->rate_per_month;
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

            $bundle = new Bundle();
            $bundle->add('tenant',$result['register_tenant']);
            $bundle->add('villaId',$result['villa_id']);

            event(new OnCreating($bundle));

            $tenantOutput = $bundle->getOutput('tenant');
            $villaOutput = $bundle->getOutput('villa');

            if(!$bundle->hasOutput()) {
                throw new Exception("Internal error occured");
            }

            //remove tenant
            unset($result['register_tenant']);

            $contractModel = $result;

            //temp manually add user id
            $contractModel['user_id'] = 1;
            $contractModel['tenant_id'] = $tenantOutput->id;
            $contractModel['villa_no']  = $villaOutput->villa_no;

            $contract = $this->contracts->saveContract($contractModel);

            $bundle->clearAll();

            $bundleValue = ['id' => $result['villa_id'],'status' => 'occupied'];
            $bundle->add('villa',$bundleValue);

            //trigger event since saving
            event(new NotifyUpdate($bundle));

        }
        catch(Exception $e) {
            return Result::badRequest(['message' => $e->getMessage()]);
        }

        return Result::ok("Successfully save!!!",['id' => $contract->contract_no]);
    }

    public function apiRenew($id) {

        //get the old contract including villa
        $oldContract = $this->contracts->withAssociates()->find($id);
        if(!$oldContract->isActive()) {
            return Result::badRequest(['message' => 'Contract is not active']);
        }

        //recalculate the past contract period
        $remainingPeriodDay = $oldContract->getRemainingPeriod();

        //display contract
        $oldContract->setDefaultPeriod(Carbon::now(),self::DEFAULT_PERIOD,$remainingPeriodDay);

        return $oldContract;
        
    }

    
    public function apiUpdate(RenewalForm $renewal) {
        try {

            $entity = $renewal->filterInput();

            $oldContract = $this->contracts->find($entity['id']);

            if($oldContract) {

                $bundle = new Bundle();
                $villaId = $oldContract->villa_id;
                $bundle->add('villaId',$villaId);
                event(new OnCreating($bundle));

                $villaOutput = $bundle->getOutput('villa');

                if($villaOutput != null) {

                    $entity['villa_no'] = $villaOutput->villa_no;
                    $entity['villa_id'] = $villaOutput->getId();
                    $entity['tenant_id'] = $oldContract->tenant_id;
                    $entity['contract_type'] = $oldContract->contract_type;
                    $entity['user_id'] = 1; //manually user
                    $entity['id'] = 0; //make new

                    $newContract = $this->contracts->saveContract($entity);

                    //make the old contract complete
                    $oldContract->completed()->save();
                }
            }
        }
        catch(Exception $e) {
            return Result::badRequest(['message' => $e->getMessage()]);
        }
        
        return Result::ok("Successfully update!!!",["id" => $newContract->contract_no]);
    }

    public function apiCancel(Request $request) {
        try {

            $contract = $this->contracts->find($request->input('id'));

            if($contract->isPending()) {

                $tenantId = $contract->tenant_id;
                $villaId = $contract->villa_id;
                $contract->delete();

                $bundle = new Bundle();

                $bundle->add('tenant',$tenantId);
                $bundleValue = ["id" => $villaId, "status" => "vacant"];
                $bundle->add("villa",$bundleValue);

                event(new NotifyUpdate($bundle));

            }
            else {
                throw new Exception("Unable to cancel the contract");
            }
        }
        catch(Exception $e) {
            return Result::badRequest(['message' => $e->getMessage()]);
        }

        return Result::ok('Succefully cancelled!!!');
    }

    public function apiTerminate(Request $request) {

        try {

            $contract = $this->contracts->find($request->input('id'));

            if($contract->isActive() && $contract->hasNoBalance()) {

                $contract->terminate()->save();

                $bundle = new Bundle();
                $bundleValue = ["id" => $villaId, "status" => "vacant"];
                $bundle->add("villa",$bundleValue);
                event(new NotifyUpdate($bundle));
            }
        }
        catch(Exception $e) {
            return Result::badRequest(['message' => $e->getMessage()]);
        }
        return Result::ok('Successfully Terminate contract');
    }


    

}
