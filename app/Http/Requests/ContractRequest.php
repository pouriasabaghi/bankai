<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // $pattern = "/^(14[0-9][0-9]|15[0-9][0-9])\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])$/";
        // if (!preg_match($pattern, $period['start']) || !preg_match($pattern, $period['end'])) {
        //     throw new \Exception('فرمت تاریخ باید به صورت 1401/01/10 باشد', 1);
        // }
        return [
            'name' => 'required',
            'customer_id' => 'required|not_in:0',
            'company_id' => 'required|not_in:0',
            'total_price' => 'required',
            'advance_payment' => 'required',
            'type' => 'required',
            'services' => 'required',
            'signed_at' => [
                'regex:/^(14[0-9][0-9]|15[0-9][0-9])\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])$/',
            ],
            'started_at' => [
                'regex:/^(14[0-9][0-9]|15[0-9][0-9])\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])$/',
            ],
            'canceled_at' => [
                'regex:/^(14[0-9][0-9]|15[0-9][0-9])\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])$/',
                'nullable',
            ]
        ];
    }
}
