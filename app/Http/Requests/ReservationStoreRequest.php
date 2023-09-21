<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\DateBetween;
use App\Rules\TimeBetween;

class ReservationStoreRequest extends FormRequest
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
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email'],
            'tel_number' => ['required'],
            'res_date' => ['required', 'date', new DateBetween(), new TimeBetween()],
            'table_id' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Le champ "Prénom" est obligatoire.',
            'last_name.required' => 'Le champ "Nom" est obligatoire.',
            'email.required' => 'Le champ "E-mail" est obligatoire.',
            'email.email' => 'Le champ "E-mail" doit être au format email.',
            'tel_number.required' => 'Le champ "Numéro de téléphone" est obligatoire.',
            'res_date.required' => 'Le champ date de réservation est obligatoire.',
            'res_date.date_format' => 'Le champ date de réservation doit être au format :format.',
            'table_id.required' => 'Le champ "Table" est obligatoire.',
        ];
    }

}
