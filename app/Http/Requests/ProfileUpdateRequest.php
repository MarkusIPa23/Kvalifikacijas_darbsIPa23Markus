<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'bio' => ['nullable', 'string', 'max:500'],
            'avatar_url' => ['nullable', 'url', 'max:2048'],
            'favorite_genre' => ['nullable', 'string', 'max:50'],
            'preferred_platform' => ['nullable', 'string', 'in:PC,PlayStation,Xbox,Switch,Mobile,VR'],
            'play_style' => ['nullable', 'string', 'in:Casual,Competitive,Co-op,Story-first,Challenge runs'],
            'gaming_status' => ['nullable', 'string', 'in:Looking for squad,Ready to compete,Chill vibes,Exploring games'],
            'profile_color' => ['sometimes', 'string', 'in:teal,coral,amber,sky'],
            'profile_visibility' => ['sometimes', 'boolean'],
            'show_favorites' => ['sometimes', 'boolean'],
        ];
    }
}
