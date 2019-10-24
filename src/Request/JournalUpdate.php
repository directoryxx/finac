<?php

namespace Directoryxx\Finac\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class JournalUpdate extends FormRequest
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
			'approve' => 'required',
			'voucher_no' => 'required',
			'transaction_date' => 'required',
			'ref_no' => 'required',
			'currency_code' => 'required',
			'exchange_rate' => 'required',
			'journal_type' => 'required',
			'total_transaction' => 'required',
			'automatic_journal_type' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator) {
		throw new HttpResponseException(response()->json(
			['errors' => $validator->errors()])
		);
    }
}
