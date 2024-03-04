<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGameMasterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'location' => 'required|string|max:100',
            'game_description' => 'required|string|max:1000',
            'max_players' => 'required|integer|min:1|max:127',
            'profile_img' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'game_systems' => 'required|array|min:1',
            'game_systems.*' => 'exists:game_systems,id',
        ];
    }

    public function messages(): array
    {
        return [
            'game_systems.required' => 'Please select at least one game system.',
            'game_systems.min' => 'Please select at least one game system.',
            'game_systems.*.exists' => 'The selected game system is invalid.',
            'max_players.max'=>'You can not select more than 127 players',
        ];
    }
}
