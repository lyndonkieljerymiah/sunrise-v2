<?php 

namespace App\Repositories;

use App\Payment;
use Carbon\Carbon;

class BillRepository extends AbstractRepository {

    protected function definedModel() {
        return new \App\ContractBill();
    }

    public function createNewBill($contractId) {

        return $this->model->createInstance($contractId);
    }

    public function saveBill($model = array()) {

        //update
        if(isset($model['id']) && $model['id'] != 0) {

        }
        else {

            //create bill
            $this->model->bill_no = "B".$model['contract_id']."-".Carbon::now()->year."-".$this->createNewId();
            $this->model->contract_id = $model['contract_id'];
            $this->model->status = "active";
            $this->model->toSave(true);
            $billId = $this->model->id;
            if(isset($model['payments']) && sizeof($model['payments']) > 0) {
                foreach($model['payments'] as $rows) {
                    $rows['bill_id'] = $billId;
                    $payment = new Payment();
                    $payment->toMap($rows);
                    $payment->toSave(true);
                }
            }
        }
    }

    public function savePayment() {

    }
    

}