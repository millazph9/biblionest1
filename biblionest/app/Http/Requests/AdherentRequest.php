<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdherentRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     */
    public function authorize(): bool
    {
        return true; // Permet à tous les utilisateurs d'accéder à cette requête
    }

    /**
     * Définit les règles de validation pour la requête.
     */
    public function rules(): array
    {
        return [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:adherents,email,' . $this->route('adherent'),
            'phone_number' => 'required|regex:/^0[1-9][0-9]{8}$/',
            'address' => 'required|string|max:255',
        ];
    }

    /**
     * Messages d'erreur personnalisés.
     */
    public function messages(): array
    {
        return [
            'firstname.required' => 'Le prénom est obligatoire.',
            'lastname.required' => 'Le nom est obligatoire.',
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'phone_number.required' => 'Le numéro de téléphone est obligatoire.',
            'phone_number.regex' => 'Le numéro de téléphone doit contenir 10 chiffres et commencer par 0.',
            'address.required' => 'L\'adresse est obligatoire.',
        ];
    }
}
