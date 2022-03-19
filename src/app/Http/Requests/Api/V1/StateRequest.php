<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StateRequest extends FormRequest
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
                    'name'  => ['required', 'string'],
                    'description'   => ['required', 'string'],
                ];
                break;
            case 'GET':
                return [
                    'id'  => ['required', 'numeric', 'exists:states,id,id,'.$this->id],
                ];
                break;
            case 'PUT':
                return [
                    'id'  => ['required', 'numeric', 'exists:states,id,id,'.$this->id],
                    'name'  => ['required', 'string'],
                    'description'   => ['required', 'string'],
                ];
                break;
            case 'PATCH':
                return [
                    'id'  => ['required', 'numeric', 'exists:states,id,id,'.$this->id],
                    'name'  => ['nullable', 'string'],
                    'description'   => ['nullable', 'string'],
                ];
                break;
            case 'DELETE':
                return [
                    'id'  => ['required', 'numeric', 'exists:states,id,id,'.$this->id],
                ];
                break;
            default:
                return [];
                break;
        }
    }
}
