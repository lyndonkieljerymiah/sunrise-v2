<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'effectivity_date'  =>  'required|date',
            'period_start'      =>  'required|date',
            'period_end'        =>  'required|date',
            'bank'              =>  'required',
            'payment_no'        =>  'required',
            'amount'            =>  array('required','regex:/^\d+?|^\d+\.\d{2}?/')
        ];
    }
}
