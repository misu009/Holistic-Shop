<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PrimaryCollaboratorNotInSecondary implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        dd(2);
        $primary = request()->input('primary_collaborators', []);
        $secondary = request()->input('secondary_collaborators', []);

        if (array_intersect($primary, $secondary)) {
            $fail('Primary collaborators cannot be in secondary collaborators.');
        }
    }
}
