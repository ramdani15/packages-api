<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'payment_type_id'  => ['required', 'numeric', 'exists:payment_types,id,id,'.$this->payment_type_id],
                    'state_id'  => ['required', 'numeric', 'exists:states,id,id,'.$this->state_id],
                    'amount'   => ['required', 'string'],
                    'discount'   => ['required', 'string'],
                    'additional_field'   => ['nullable', 'string'],
                    'code'   => ['required', 'string'],
                    'order'   => ['required', 'numeric'],
                    'cash_amount'   => ['required', 'numeric', 'between:0,999.99'],
                    'cash_change'   => ['required', 'numeric', 'between:0,999.99'],
                    'custome_fields.*'   => ['nullable', 'array'],
                ];
                break;
            case 'GET':
                return [
                    'id'  => ['required', 'numeric', 'exists:transactions,id,id,'.$this->id],
                ];
                break;
            case 'PUT':
                return [
                    'id'  => ['required', 'numeric', 'exists:transactions,id,id,'.$this->id],
                    'payment_type_id'  => ['required', 'numeric', 'exists:payment_types,id,id,'.$this->payment_type_id],
                    'state_id'  => ['required', 'numeric', 'exists:states,id,id,'.$this->state_id],
                    'amount'   => ['required', 'string'],
                    'discount'   => ['required', 'string'],
                    'additional_field'   => ['nullable', 'string'],
                    'code'   => ['required', 'string'],
                    'order'   => ['required', 'numeric'],
                    'cash_amount'   => ['required', 'numeric', 'between:0,999.99'],
                    'cash_change'   => ['required', 'numeric', 'between:0,999.99'],
                    'custome_fields.*'   => ['nullable', 'array'],
                ];
                break;
            case 'PATCH':
                return [
                    'id'  => ['required', 'numeric', 'exists:transactions,id,id,'.$this->id],
                    'payment_type_id'  => ['nullable', 'numeric', 'exists:payment_types,id,id,'.$this->payment_type_id],
                    'state_id'  => ['nullable', 'numeric', 'exists:states,id,id,'.$this->state_id],
                    'amount'   => ['nullable', 'string'],
                    'discount'   => ['nullable', 'string'],
                    'additional_field'   => ['nullable', 'string'],
                    'code'   => ['nullable', 'string'],
                    'order'   => ['nullable', 'numeric'],
                    'cash_amount'   => ['nullable', 'numeric', 'between:0,999.99'],
                    'cash_change'   => ['nullable', 'numeric', 'between:0,999.99'],
                    'custome_fields.*'   => ['nullable', 'array'],
                ];
                break;
            case 'DELETE':
                return [
                    'id'  => ['required', 'numeric', 'exists:transactions,id,id,'.$this->id],
                ];
                break;
            default:
                return [];
                break;
        }
    }
}
