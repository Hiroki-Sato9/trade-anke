<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        // dd($this->user());
        return [
            'user.name' => ['string', 'max:255'],
            // 'user.email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'user.email' => ['email', 'max:255', Rule::unique('users', 'email')->ignore($this->user()->id)],
            'profile.gender_id' => ['required', 'numeric'],
            'profile.age' => ['required', 'numeric', 'min:1'],
        ];
    }
}

