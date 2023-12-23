<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxWords implements ValidationRule
{
    private $maxWord;

    public function __construct($maxWords)
    {
        $this->maxWord = $maxWords;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $words = str_word_count($value);

        if($words > $this->maxWord){
            $fail(str_replace('_', ' ', 'The ' . $attribute . ' must not exceed ' . $this->maxWord . ' words' ));
        }
    }
}
