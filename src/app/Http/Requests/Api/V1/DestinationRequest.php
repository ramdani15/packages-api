<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class DestinationRequest extends FormRequest
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
                    'transaction_id'  => ['required', 'numeric', 'exists:transactions,id,id,'.$this->transaction_id],
                    'customer_id'  => ['required', 'numeric', 'exists:customers,id,id,'.$this->customer_id],
                ];
                break;
            case 'GET':
                return [
                    'id'  => ['required', 'numeric', 'exists:destinations,id,id,'.$this->id],
                ];
                break;
            case 'PUT':
                return [
                    'id'  => ['required', 'numeric', 'exists:destinations,id,id,'.$this->id],
                    'transaction_id'  => ['required', 'numeric', 'exists:transactions,id,id,'.$this->transaction_id],
                    'customer_id'  => ['required', 'numeric', 'exists:customers,id,id,'.$this->customer_id],
                ];
                break;
            case 'PATCH':
                return [
                    'id'  => ['required', 'numeric', 'exists:destinations,id,id,'.$this->id],
                    'transaction_id'  => ['nullable', 'numeric', 'exists:transactions,id,id,'.$this->transaction_id],
                    'customer_id'  => ['nullable', 'numeric', 'exists:customers,id,id,'.$this->customer_id],
                ];
                break;
            case 'DELETE':
                return [
                    'id'  => ['required', 'numeric', 'exists:destinations,id,id,'.$this->id],
                ];
                break;
            default:
                return [];
                break;
        }
    }
}
