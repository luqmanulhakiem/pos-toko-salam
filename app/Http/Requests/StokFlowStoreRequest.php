<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StokFlowStoreRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "produk_id" => ["required", "integer"],
            "quantity" => ["required", "integer"],
            "type" => ["required", "in:masuk,keluar"],
            "description" => ["required", "string"],
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        toastr()->error('Gagal Login');

        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            redirect()->back()->withErrors($validator)->withInput()
        );
    }
}
