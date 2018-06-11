<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BilletRequest extends FormRequest
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
            "billet" => 'bail|required|size:14|alpha_num' //|size:8 ne marche pas avec integer
        ];
    }

    public function messages()
    {
      return [
          'billet.required' => 'Vous devez entrer un numéro de billet',
          'billet.size' => 'Vous devez entrer exactement :size carractères',
          'billet.alpha_num' => 'Vous devez entrer uniquement des chiffres ou des lettres',
      ];
    }
}
