<?php

namespace App;

use App\Services\Result;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class ContractBill extends BaseModel
{

    const DEFAULT_PERIOD = 1;

    public function __construct(array $attributes = [])
    {
        $this->created_at = Carbon::now();
        $this->updated_at = Carbon::now();
        $this->status = "pending";

        parent::__construct($attributes);

    }

    public function Payments() {

        return $this->hasMany(Payment::class,'bill_id','id');
    }

    public static function createInstance($contractId) {

        $bill = new ContractBill();
        $bill->contract_id = $contractId;
        $bill->instance = Payment::createInstance();
        $bill->instance->initPeriod(self::DEFAULT_PERIOD);
        $bill->payments = [];

        return $bill;
    }

    public function activate() {

        $this->status = 'active';

        return $this;
    }

    public function withPaymentStatusOf($status) {

        return $this->with(array('payments' => function($query) use($status) {

            $query->where('status',$status);
        }));
    }

    public function getSummary() {
        $billId = $this->getId();
        return $this->Payments()->select('status',DB::raw('SUM(amount) AS sumAmount'))->groupBy('status')->where('bill_id',$billId)->get();

    }

    public function withPaymentLine() {
        return $this->with('Payments');
    }

    public function saveBill($entity) {
        try {

            //validate payment first
            $this->bill_no = "B" . $entity['contract_id'] . "-" . Carbon::now()->year . "-" . $this->createNewId();
            $this->contract_id = $entity['contract_id'];
            $this->user_id = $entity['user_id'];

            $this->save();

            if(isset($entity['payments']) && sizeof($entity['payments']) > 0) {
                $this->Payments()->saveMany(array_map(function ($item) {
                    $payment = new Payment();
                    $payment->user_id = 1;  //manually
                    $payment->toMap($item);
                    return $payment;

                }, $entity['payments']));
            }

            return true;
        }
        catch (Exception $e) {
            abort(500,$e->getMessage());
        }
    }

    public function updatePayment($entity) {

        try {

            //get the current bill
            $currentBill = $this->find($entity['id']);

            //update its payment
            $entityPayments = isset($entity['payments']) ? $entity['payments'] : [];
            if (sizeof($entityPayments) > 0) {
                foreach ($entityPayments as $entityPayment) {
                    //update only without received
                    if ($entityPayment['status'] != 'received') {
                        $paymentModel = $currentBill->Payments()->find($entityPayment['id']);
                        if ($paymentModel != null) {
                            $paymentModel->status = $entityPayment['status'];
                            $paymentModel->remarks = $entityPayment['remarks'];
                            $paymentModel->save();
                        }
                        else {

                        }
                    }
                }
            }
            return $currentBill;
        }
        catch(Exception $e) {
            Result::badRequest(['exception' => $e->getMessage()]);
        }

        return false;
    }

    public function isBalance($entity,$contractAmount) {

        if(isset($entity['payments']) && sizeof($entity['payments']) > 0) {
            $amountReceived = 0;
            foreach($entity['payments'] as $payment) {
                $amountReceived += (float)$payment['amount'];
            }
            if($amountReceived >= $contractAmount) {
                return true;
            }
        }

        return false;

    }

    public function getBillByNo($billNo) {
        return $this->where('bill_no',$billNo)->get();
    }

    public function getExistingContract($contractNo) {

        $raw =  DB::table('contracts AS c')
                ->select('cb.bill_no')
                ->join('contract_bills AS cb','c.id', '=' ,'cb.contract_id')
                ->where('c.contract_no','=',$contractNo)
                ->first();

        return $raw;

    }




}
