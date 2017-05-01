<?php

namespace App\Repositories;

use Carbon\Carbon;

use App\Selection;

class ContractRepository extends AbstractRepository {

    protected $parameters;
  

    public function definedModel() {

        return new \App\Contract();
    }
  
   

    public function saveContract($model) {

        $villaNo = $model['villa_no'];

        unset($model['villa_no']);
        
        $model['contract_no'] = "C".$villaNo."-".Carbon::now()->year."-".$this->createNewId();
        
        $this->attach($model,'create');

        return $this;

    }

    public function renew($models) {
        
        $contract = $this->single($models['id']);

        if($contract->hasStatusOf(Contract::ACTIVE)) {
            
            $oldContractNo = $contract->contract_no;
            
            preg_match('/^([^-]+?)-([0-9]+?)-([0-9]+?)$/',$oldContractNo,$splits);

            if(sizeof($splits) > 0)  {
                array_splice($splits,0,1); //exclude the whole contractno
                $splits[1] = Carbon::now()->year;
                $splits[2] = $this->createNewId();
            }

            $newContractNo = implode('-',$splits);
            $contract->completed();
            $contract->save();
            
            //set contract no
            $model['contract_no'] = $newContractNo;
            
            $this->attach($models,"create");

            return true;
        }
        else {
            
            return false;
        }  
    }

    public function cancelled($models) {

        $contract = $this->single($models['id']);

        if($contract->hasStatusOf(Contract::PENDING)) {

            $contract->cancel();

        }

        return true;
    }

    public function getContracts($status = "") {

        return $this->model->lists($status);

    }

    public function create($defaultMonths) {

        return \App\Contract::createInstance($defaultMonths);

    }

    public function terminate($models = array()) {

        $contract = $this->single($models['id']);
        
        if($contract->hasStatusOf(Contract::ACTIVE)) {
            $this->contract->terminate();
            $this->contract->save();
        }
        
        return true;
    }

    public function calculateAmount($ratePerMonth) {
        
        $this->model->toComputeAmount($ratePerMonth);

        return $this;

    }





}