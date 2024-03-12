<?php

namespace App\Rules;

use App\Models\Promotion;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidPromotion implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!Promotion::find($value, 'id')) {
            $fail("The selected $attribute is invalid.");
        }
    }


}
