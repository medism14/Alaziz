<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuStoreRequest extends FormRequest
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
            'name' => ['required'],
            'description' => ['required'],
            'image' => ['required', 'image'],
            'price' => ['required'],
            'categories' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'le champ nom est obligatoire',
            'description.required' => 'le champ description est obligatoire',
            'image.required' => 'le champ image est obligatoire',
            'price.required' => 'le champ prix est obligatoire',
            'categories' => 'le champ categorie est obligatoire',
        ];
    }
}
