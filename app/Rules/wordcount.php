<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class wordcount implements ValidationRule
{
    private $params = [];

    public function __construct($params)
    {
        $this->params = $params;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $words = str_word_count($value);
        if ($words > current($this->params)) {
            $fail("The :attribute must be less than ".current($this->params)." words.");
        }
    }
}
