<?php

namespace App\Http\Controllers;

use App\Repositories\SelectionRepository;
use Illuminate\Http\Request;

class ContractBillController extends Controller
{
    
    private $contracts;
    private $bills;
    private $selections;


    public function __construct(
        \App\Repositories\ContractRepository $contracts,
        \App\Repositories\SelectionRepository $selectionRepository,
        \App\Repositories\BillRepository $bills) {

            $this->contracts = $contracts;
            $this->selections = $selectionRepository;
            $this->bills = $bills;

        }

    public function create($contractId) {

        //get the contract 
        $contract = $this->contracts->findById($contractId)->getAssociates();
        $bill = $this->bills->createNewBill($contractId);
        $lookups = $this->selections->getSelections(array("payment_mode","payment_term"));

        //get villa
        return compact("bill","contract","lookups");
    }

    public function edit($id) {

    }
}
