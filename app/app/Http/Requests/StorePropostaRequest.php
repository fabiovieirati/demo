<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class StorePropostaRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'planoEscolhido' => ['required'],
            'quantidadeBeneficiarios' => ['required', 'integer'],
            'beneficiarios.*.idade' => ['required', 'integer'],
            'beneficiarios.*.nome' => ['required']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'planoEscolhido.required' => 'Plano e um campo nescessario',
            'quantidadeBeneficiarios.required' => 'Quantidade beneficiario e um campo nescessario',
            'beneficiarios.*.nome.required' => 'O Campo nome esta vazio',
            'beneficiarios.*.idade.required' => 'O Campo idade esta vazio',
            'quantidadeBeneficiarios.integer' => 'Quantidade beneficiario precisa ser um numero',
            'beneficiarios.*.idade.integer' => 'O Campo idade precisa ser um numero'
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
        throw (new ValidationException($validator))
                    ->errorBag($this->errorBag)
                    ->redirectTo($this->getRedirectUrl())
                    ->status(Response::HTTP_OK);
    }
}
