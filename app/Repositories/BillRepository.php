<?php 

namespace App\Repositories;

class BillRepository extends AbstractRepository {

    protected function definedModel() {
        return new \App\ContractBill();
    }

    public function createNewBill($contractId) {

        return \App\ContractBill::createInstance($contractId);
    }

    public function saveBill() {

    }

    public function savePayment() {

    }
    

}