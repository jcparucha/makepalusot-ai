<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class TextRule implements ValidationRule
{
    public function __construct(private ?string $allowCharacters = ".,-'()[]/") {}

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_array($value)) {
            return;
        }

        $characters = $this->allowCharacters ? preg_quote($this->allowCharacters, '/') : '';

        $pattern = '/^[\pL\s\pN'.$characters.']+$/u';

        if (! preg_match($pattern, $value)) {
            $fail($this->getMessage());
        }
    }

    private function getMessage(): string
    {
        $message = 'The :attribute field must only contain letters';

        if (! is_null($this->allowCharacters)) {
            // message: "...contain letters and special characters (..,-'()[]/)"
            $message .= " and special characters ($this->allowCharacters)";
        }

        return $message .= '.';
    }
}
