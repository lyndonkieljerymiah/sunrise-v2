<?php

namespace App\Http\Controllers;

use App\Contract;
use App\ContractBill;
use App\Events\Bill\NotifyUpdate;
use App\Events\Contract\OnInitialize;
use App\Http\Requests\BillForm;
use App\Selection;
use App\Services\Bundle;
use App\Services\Result;
use Dotenv\Validator;
use Illuminate\Support\Collection;


class ContractBillController extends Controller
{

    private $bills;

    public function __construct() {

        $this->bills = new ContractBill();

    }

    public function create($contractNo)
    {
        $contract = $this->bills->getExistingContract($contractNo);
        if(!empty($contract)) {
           return redirect()
               ->action("ContractBillController@show",['billNo' => $contract->bill_no]);
       }

       return view("bill.entry",compact('contractNo'));
    }

    public function apiCreate($contractNo) {

        //get the contract
        $contractModel = new Contract();
        $contract = $contractModel
            ->withAssociates()
            ->where('contract_no',$contractNo)
            ->first();

        $bill = $this->bills->createInstance($contract->id);

        $bill->instance->amount = $contract->payable_per_month;

        //set bill payment to rate per month
        $selection = new Selection();
        $lookups = $selection->getSelections(array("payment_mode","payment_term","payment_status"));

        //get villa
        return compact("bill","contract","lookups");
    }

    public function apiStore(BillForm $request) {

        $inputs = $request->filterInput();
        $inputs['user_id'] = 1;

        //get contract and validate payment
        $contract = Contract::find($inputs['contract_id']);

        $isBalance = $this->bills->isBalance($inputs,$contract->amount);

        if(!$isBalance) {
            return Result::badRequest(['payments' => 'Total payment amount is insufficient']);
        }

        $this->bills->saveBill($inputs);
        $bundle = new Bundle();
        $bundle->add('contract',$inputs['contract_id']);

        //notify update
        event(new NotifyUpdate($bundle));

        return Result::ok('Successfully Save',["billNo" => $this->bills->bill_no]);


    }

    public function edit() {

        return view("bill.payment");
    }

    public function apiEdit($billNo) {

        $bill = $this->bills->withPaymentLine()->where('bill_no',$billNo)->first();
        $contractModel = new Contract();
        $contract = $contractModel->withAssociates()->find($bill->contract_id);

        //set bill payment to rate per month
        $selection = new Selection();
        $lookups = $selection->getSelections(array("payment_status"));

        return compact('bill','contract','lookups');

    }

    public function apiUpdate($billNo) {

        $bill = $this->bills->withPending($billNo);



    }

    public function show($billNo) {

        return view('bill.display',compact('billNo'));
    }


    public function apiShow($billNo) {

       //show
        $bill = $this->bills->withPaymentLine()->where('bill_no',$billNo)->first();

        $contractModel = new Contract();

        $contract =$contractModel->withAssociates()->find($bill->contract_id);

        return compact('bill','contract');
    }
}
