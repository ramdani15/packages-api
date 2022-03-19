<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
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
                    'origin_customer_id'  => ['required', 'numeric', 'exists:customers,id,id,'.$this->origin_customer_id],
                    'destination_customer_id'  => ['required', 'numeric', 'exists:customers,id,id,'.$this->destination_customer_id],

                    'connote.source_tariff_id'  => ['required', 'numeric', 'exists:source_tariffs,id,id,'.$this->connote['source_tariff_id']],
                    'connote.state_id'  => ['required', 'numeric', 'exists:states,id,id,'.$this->connote['state_id']],
                    'connote.service'   => ['required', 'string'],
                    'connote.code'   => ['required', 'string'],
                    'connote.booking_code'   => ['nullable', 'string'],
                    'connote.actual_weight'   => ['required', 'numeric', 'between:0,999.99'],
                    'connote.volume_weight'   => ['required', 'numeric', 'between:0,999.99'],
                    'connote.chargeable_weight'   => ['required', 'numeric', 'between:0,999.99'],
                    'connote.total_package'   => ['required', 'numeric'],
                    'connote.surcharge_amount'   => ['required', 'numeric'],
                    'connote.sla_day'   => ['required', 'numeric'],
                    'connote.pod'   => ['nullable', 'string'],

                    'kolis.*.length'   => ['required', 'numeric'],
                    'kolis.*.awb_url'   => ['required', 'string'],
                    'kolis.*.chargeable_weight'   => ['required', 'numeric', 'between:0,999.99'],
                    'kolis.*.width'   => ['required', 'numeric'],
                    'kolis.*.height'   => ['required', 'numeric'],
                    'kolis.*.description'   => ['required', 'string'],
                    'kolis.*.volume'   => ['required', 'numeric', 'between:0,999.99'],
                    'kolis.*.weight'   => ['required', 'numeric'],
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
                    'origin_customer_id'  => ['required', 'numeric', 'exists:customers,id,id,'.$this->origin_customer_id],
                    'destination_customer_id'  => ['required', 'numeric', 'exists:customers,id,id,'.$this->destination_customer_id],

                    'connote.source_tariff_id'  => ['required', 'numeric', 'exists:source_tariffs,id,id,'.$this->connote['source_tariff_id']],
                    'connote.state_id'  => ['required', 'numeric', 'exists:states,id,id,'.$this->connote['state_id']],
                    'connote.service'   => ['required', 'string'],
                    'connote.code'   => ['required', 'string'],
                    'connote.booking_code'   => ['nullable', 'string'],
                    'connote.actual_weight'   => ['required', 'numeric', 'between:0,999.99'],
                    'connote.volume_weight'   => ['required', 'numeric', 'between:0,999.99'],
                    'connote.chargeable_weight'   => ['required', 'numeric', 'between:0,999.99'],
                    'connote.total_package'   => ['required', 'numeric'],
                    'connote.surcharge_amount'   => ['required', 'numeric'],
                    'connote.sla_day'   => ['required', 'numeric'],
                    'connote.pod'   => ['nullable', 'string'],

                    'kolis.*.length'   => ['required', 'numeric'],
                    'kolis.*.awb_url'   => ['required', 'string'],
                    'kolis.*.chargeable_weight'   => ['required', 'numeric', 'between:0,999.99'],
                    'kolis.*.width'   => ['required', 'numeric'],
                    'kolis.*.height'   => ['required', 'numeric'],
                    'kolis.*.description'   => ['required', 'string'],
                    'kolis.*.volume'   => ['required', 'numeric', 'between:0,999.99'],
                    'kolis.*.weight'   => ['required', 'numeric'],
                ];
                break;
            case 'PATCH':
                $rules = [
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
                    'origin_customer_id'  => ['nullable', 'numeric', 'exists:customers,id,id,'.$this->origin_customer_id],
                    'destination_customer_id'  => ['nullable', 'numeric', 'exists:customers,id,id,'.$this->destination_customer_id],

                    'connote.source_tariff_id'  => ['nullable', 'numeric', 'exists:source_tariffs,id,id,'.($this->connote['source_tariff_id'] ?? null)],
                    'connote.state_id'  => ['nullable', 'numeric', 'exists:states,id,id,'.($this->connote['state_id'] ?? null)],
                    'connote.service'   => ['nullable', 'string'],
                    'connote.code'   => ['nullable', 'string'],
                    'connote.booking_code'   => ['nullable', 'string'],
                    'connote.actual_weight'   => ['nullable', 'numeric', 'between:0,999.99'],
                    'connote.volume_weight'   => ['nullable', 'numeric', 'between:0,999.99'],
                    'connote.chargeable_weight'   => ['nullable', 'numeric', 'between:0,999.99'],
                    'connote.total_package'   => ['nullable', 'numeric'],
                    'connote.surcharge_amount'   => ['nullable', 'numeric'],
                    'connote.sla_day'   => ['nullable', 'numeric'],
                    'connote.pod'   => ['nullable', 'string'],

                    'kolis.*.length'   => ['nullable', 'numeric'],
                    'kolis.*.awb_url'   => ['nullable', 'string'],
                    'kolis.*.chargeable_weight'   => ['nullable', 'numeric', 'between:0,999.99'],
                    'kolis.*.width'   => ['nullable', 'numeric'],
                    'kolis.*.height'   => ['nullable', 'numeric'],
                    'kolis.*.description'   => ['nullable', 'string'],
                    'kolis.*.volume'   => ['nullable', 'numeric', 'between:0,999.99'],
                    'kolis.*.weight'   => ['nullable', 'numeric'],
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
