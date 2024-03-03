<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGameMasterRequest extends FormRequest
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
                'users_id' => 'required|exists:users,id',
                'location' => 'required|string|max:100',
                'game_description' => 'required|string|max:1000',
                'max_players' => 'required|integer|min:1',
                'profile_img' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'is_active' => 'required|boolean',
                'is_available' => 'required|boolean',
                'slug' => [
                    'required',
                    'string',
                    'max:150',
                    Rule::unique('game_masters')->ignore($this->game_master),
                ],
        ];
    }
}