<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
                    'location_id'  => ['required', 'numeric', 'exists:locations,id,id,'.$this->location_id],
                    'organization_id'  => ['required', 'numeric', 'exists:organizations,id,id,'.$this->organization_id],
                    'name' => ['required', 'string'],
                    'code' => ['required', 'string'],
                    'address' => ['required', 'string'],
                    'address_detail' => ['nullable', 'string'],
                    'email' => ['required', 'email'],
                    'phone' => ['required', 'string'],
                    'nama_sales' => ['nullable', 'string'],
                    'top' => ['nullable', 'string'],
                    'jenis_pelanggan' => ['nullable', 'string'],
                ];
                break;
            case 'GET':
                return [
                    'id'  => ['required', 'numeric', 'exists:customers,id,id,'.$this->id],
                ];
                break;
            case 'PUT':
                return [
                    'id'  => ['required', 'numeric', 'exists:customers,id,id,'.$this->id],
                    'location_id'  => ['required', 'numeric', 'exists:locations,id,id,'.$this->location_id],
                    'organization_id'  => ['required', 'numeric', 'exists:organizations,id,id,'.$this->organization_id],
                    'name' => ['required', 'string'],
                    'code' => ['required', 'string'],
                    'address' => ['required', 'string'],
                    'address_detail' => ['nullable', 'string'],
                    'email' => ['required', 'email'],
                    'phone' => ['required', 'string'],
                    'nama_sales' => ['nullable', 'string'],
                    'top' => ['nullable', 'string'],
                    'jenis_pelanggan' => ['nullable', 'string'],
                ];
                break;
            case 'PATCH':
                return [
                    'id'  => ['required', 'numeric', 'exists:customers,id,id,'.$this->id],
                    'location_id'  => ['nullable', 'numeric', 'exists:locations,id,id,'.$this->location_id],
                    'organization_id'  => ['nullable', 'numeric', 'exists:organizations,id,id,'.$this->organization_id],
                    'name' => ['nullable', 'string'],
                    'code' => ['nullable', 'string'],
                    'address' => ['nullable', 'string'],
                    'address_detail' => ['nullable', 'string'],
                    'email' => ['nullable', 'email'],
                    'phone' => ['nullable', 'string'],
                    'nama_sales' => ['nullable', 'string'],
                    'top' => ['nullable', 'string'],
                    'jenis_pelanggan' => ['nullable', 'string'],
                ];
                break;
            case 'DELETE':
                return [
                    'id'  => ['required', 'numeric', 'exists:customers,id,id,'.$this->id],
                ];
                break;
            default:
                return [];
                break;
        }
    }
}
