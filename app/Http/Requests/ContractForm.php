<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractForm extends FormRequest
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
            "period_start"  => "required|date",

            "period_end"    => "required|date",

            "amount"        => "required|regex:/^\d+\.\d{2}?/"
        ];
    }

    public function getValidatorInstance() {

        $validator = parent::getValidatorInstance();

        $validator->after(function() use ($validator){
            
            $input = $this->formInput();

            $periodStart = $this->carbon->parse($input['period_start']);
            $periodEnd = $this->carbon->parse($input['period_end']);

            if($this->carbon->now()->lt($periodStart)) {
                $this->errors()->add('start','Start must be current of future date');
            }

            if($periodStart > $periodEnd) {
                $this->errors()->add('start','Start must be later than end date');
            }
            
        });

        return $validator;
    }
}
