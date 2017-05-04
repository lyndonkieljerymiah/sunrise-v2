<?php

namespace App\Http\Controllers;

use App\Events\Contract\OnInitialize;
use App\Http\Requests\BillForm;
use App\Services\Result;


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
        $contract = $this->contracts->withAssociates()->single($contractId);

        $bill = $this->bills->createNewBill($contractId);

        $bill->instance->amount = $contract->payable_per_month;
        //set bill payment to rate per month

        $lookups = $this->selections->getSelections(array("payment_mode","payment_term","payment_status"));

        //get villa
        return compact("bill","contract","lookups");
    }

    public function store(BillForm $request) {

        $this->bills->saveBill($request->filterInput());

        return Result::ok('Successfully Save');
    }

    public function edit($id) {

    }

    public function show($id) {

        $bill = $this->bills->withAssociates()->single($id);

        $contract = $this->contracts->withAssociates()->single($bill->contract_id);

        return compact('contract','bill');
    }
}
