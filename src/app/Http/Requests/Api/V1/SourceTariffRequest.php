<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class SourceTariffRequest extends FormRequest
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
                    'db'   => ['required', 'string'],
                ];
                break;
            case 'GET':
                return [
                    'id'  => ['required', 'numeric', 'exists:source_tariffs,id,id,'.$this->id],
                ];
                break;
            case 'PUT':
                return [
                    'id'  => ['required', 'numeric', 'exists:source_tariffs,id,id,'.$this->id],
                    'db'  => ['required', 'string'],
                ];
                break;
            case 'PATCH':
                return [
                    'id'  => ['required', 'numeric', 'exists:source_tariffs,id,id,'.$this->id],
                    'db'  => ['nullable', 'string'],
                ];
                break;
            case 'DELETE':
                return [
                    'id'  => ['required', 'numeric', 'exists:source_tariffs,id,id,'.$this->id],
                ];
                break;
            default:
                return [];
                break;
        }
    }
}
