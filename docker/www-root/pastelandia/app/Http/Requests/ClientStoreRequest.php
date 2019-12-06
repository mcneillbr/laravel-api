<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ClientStoreRequest extends FormRequest
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
            'nome' => 'required|string|max:128',
            'email' => 'required|email|unique:clients',
            'telefone' => 'nullable|min:11|max:25|regex:/^(?:\(?\+?[0-9]{1,3}\)?\s?)?(?:\(?\d{2,3}\)?)(?:[\.\s\-]?)?\d(?:[\.\s\-]?)?\d{3,4}(?:[\.\s\-]?)?\d{4}$/',
            'data_nascimento' => 'required|date',
            'endereco' => 'required|max:255',
            'complemento' => 'required|max:255',
            'bairro' => 'required|max:255',
            'cep' => 'required|min:9|max:9|regex:/^(?:\d{5,5})(?:[\.\-\s])(?:\d{3,3})$/',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(['errors' => $errors
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => ':attribute is required!',
            'nome.required' => ':attribute is required!',
            'nome.max' => 'The :attribute may not be greater than :max characters.',
        ];
    }
}

