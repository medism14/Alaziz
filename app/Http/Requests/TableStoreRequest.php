<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TableStoreRequest extends FormRequest
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
            'guest_number' => ['required'],
            'status' => ['required'],
            'location' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'le champ nom est obligatoire',
            'guest_number.required' => 'le champ guest_number est obligatoire',
            'status.required' => 'le champ statut est obligatoire',
            'location.required' => 'le champ location est obligatoire',
        ];
    }
}
