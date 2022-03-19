<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class ConnoteRequest extends FormRequest
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
                    'source_tariff_id'  => ['required', 'numeric', 'exists:source_tariffs,id,id,'.$this->source_tariff_id],
                    'state_id'  => ['required', 'numeric', 'exists:states,id,id,'.$this->state_id],
                    'order'   => ['required', 'numeric'],
                    'number'   => ['required', 'numeric'],
                    'service'   => ['required', 'string'],
                    'code'   => ['required', 'string'],
                    'booking_code'   => ['nullable', 'string'],
                    'actual_weight'   => ['required', 'numeric', 'between:0,999.99'],
                    'volume_weight'   => ['required', 'numeric', 'between:0,999.99'],
                    'chargeable_weight'   => ['required', 'numeric', 'between:0,999.99'],
                    'total_package'   => ['required', 'numeric'],
                    'surcharge_amount'   => ['required', 'numeric'],
                    'sla_day'   => ['required', 'numeric'],
                    'pod'   => ['nullable', 'string'],
                ];
                break;
            case 'GET':
                return [
                    'id'  => ['required', 'numeric', 'exists:connotes,id,id,'.$this->id],
                ];
                break;
            case 'PUT':
                return [
                    'id'  => ['required', 'numeric', 'exists:connotes,id,id,'.$this->id],
                    'transaction_id'  => ['required', 'numeric', 'exists:transactions,id,id,'.$this->transaction_id],
                    'source_tariff_id'  => ['required', 'numeric', 'exists:source_tariffs,id,id,'.$this->source_tariff_id],
                    'state_id'  => ['required', 'numeric', 'exists:states,id,id,'.$this->state_id],
                    'order'   => ['required', 'numeric'],
                    'number'   => ['required', 'numeric'],
                    'service'   => ['required', 'string'],
                    'code'   => ['required', 'string'],
                    'booking_code'   => ['nullable', 'string'],
                    'actual_weight'   => ['required', 'numeric', 'between:0,999.99'],
                    'volume_weight'   => ['required', 'numeric', 'between:0,999.99'],
                    'chargeable_weight'   => ['required', 'numeric', 'between:0,999.99'],
                    'total_package'   => ['required', 'numeric'],
                    'surcharge_amount'   => ['required', 'numeric'],
                    'sla_day'   => ['required', 'numeric'],
                    'pod'   => ['nullable', 'string'],
                ];
                break;
            case 'PATCH':
                return [
                    'id'  => ['required', 'numeric', 'exists:connotes,id,id,'.$this->id],
                    'transaction_id'  => ['nullable', 'numeric', 'exists:transactions,id,id,'.$this->transaction_id],
                    'source_tariff_id'  => ['nullable', 'numeric', 'exists:source_tariffs,id,id,'.$this->source_tariff_id],
                    'state_id'  => ['nullable', 'numeric', 'exists:states,id,id,'.$this->state_id],
                    'order'   => ['nullable', 'numeric'],
                    'number'   => ['nullable', 'numeric'],
                    'service'   => ['nullable', 'string'],
                    'code'   => ['nullable', 'string'],
                    'booking_code'   => ['nullable', 'string'],
                    'actual_weight'   => ['nullable', 'numeric', 'between:0,999.99'],
                    'volume_weight'   => ['nullable', 'numeric', 'between:0,999.99'],
                    'chargeable_weight'   => ['nullable', 'numeric', 'between:0,999.99'],
                    'total_package'   => ['nullable', 'numeric'],
                    'surcharge_amount'   => ['nullable', 'numeric'],
                    'sla_day'   => ['nullable', 'numeric'],
                    'pod'   => ['nullable', 'string'],
                ];
                break;
            case 'DELETE':
                return [
                    'id'  => ['required', 'numeric', 'exists:connotes,id,id,'.$this->id],
                ];
                break;
            default:
                return [];
                break;
        }
    }
}
