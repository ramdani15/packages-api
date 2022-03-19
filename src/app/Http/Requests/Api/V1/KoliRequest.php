<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class KoliRequest extends FormRequest
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
                    'connote_id'  => ['required', 'numeric', 'exists:connotes,id,id,'.$this->connote_id],
                    'formula_id'  => ['nullable', 'numeric', 'exists:formulas,id,id,'.$this->formula_id],
                    'code'  => ['required', 'string'],
                    'length'   => ['required', 'numeric'],
                    'awb_url'   => ['required', 'string'],
                    'chargeable_weight'   => ['required', 'numeric', 'between:0,999.99'],
                    'width'   => ['required', 'numeric'],
                    'surcharge.*'   => ['nullable', 'array'],
                    'height'   => ['required', 'numeric'],
                    'description'   => ['required', 'string'],
                    'volume'   => ['required', 'numeric', 'between:0,999.99'],
                    'weight'   => ['required', 'numeric'],
                    'custome_fields'   => ['nullable', 'array'],
                ];
                break;
            case 'GET':
                return [
                    'id'  => ['required', 'numeric', 'exists:kolis,id,id,'.$this->id],
                ];
                break;
            case 'PUT':
                return [
                    'id'  => ['required', 'numeric', 'exists:kolis,id,id,'.$this->id],
                    'connote_id'  => ['required', 'numeric', 'exists:connotes,id,id,'.$this->connote_id],
                    'formula_id'  => ['nullable', 'numeric', 'exists:formulas,id,id,'.$this->formula_id],
                    'code'  => ['required', 'string'],
                    'length'   => ['required', 'numeric'],
                    'awb_url'   => ['required', 'string'],
                    'chargeable_weight'   => ['required', 'numeric', 'between:0,999.99'],
                    'width'   => ['required', 'numeric'],
                    'surcharge.*'   => ['nullable', 'array'],
                    'height'   => ['required', 'numeric'],
                    'description'   => ['required', 'string'],
                    'volume'   => ['required', 'numeric', 'between:0,999.99'],
                    'weight'   => ['required', 'numeric'],
                    'custome_fields'   => ['nullable', 'array'],
                ];
                break;
            case 'PATCH':
                return [
                    'id'  => ['required', 'numeric', 'exists:kolis,id,id,'.$this->id],
                    'connote_id'  => ['nullable', 'numeric', 'exists:connotes,id,id,'.$this->connote_id],
                    'formula_id'  => ['nullable', 'numeric', 'exists:formulas,id,id,'.$this->formula_id],
                    'code'  => ['nullable', 'string'],
                    'length'   => ['nullable', 'numeric'],
                    'awb_url'   => ['nullable', 'string'],
                    'chargeable_weight'   => ['nullable', 'numeric', 'between:0,999.99'],
                    'width'   => ['nullable', 'numeric'],
                    'surcharge.*'   => ['nullable', 'array'],
                    'height'   => ['nullable', 'numeric'],
                    'description'   => ['nullable', 'string'],
                    'volume'   => ['nullable', 'numeric', 'between:0,999.99'],
                    'weight'   => ['nullable', 'numeric'],
                    'custome_fields'   => ['nullable', 'array'],
                ];
                break;
            case 'DELETE':
                return [
                    'id'  => ['required', 'numeric', 'exists:kolis,id,id,'.$this->id],
                ];
                break;
            default:
                return [];
                break;
        }
    }
}
