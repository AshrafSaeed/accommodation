<?php
namespace App\Rules;

use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Rule;

class BannedWord implements Rule
{
    
    /**
     * Banned Word.
     * @var  array 
    */
    private $banned_words;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->banned_words = config('trivago.banned_words');
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {   
        $banned_words = $this->getBannedWords();
        foreach((array) $banned_words as $key => $word)
        {
            $contains = Str::contains(Str::lower($value), Str::lower($word));
            if($contains) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute should not contain the words ('.$this->getBannedWordsString().')';
    }

    /**
     * Get the banned words string .
     *
     * @return string
     */
    private function getBannedWordsString(): string
    {
        return Str::lower(implode(',', $this->getBannedWords()));
    }

    /**
     * Get the banned words array .
     *
     * @return array
     */
    public function getBannedWords(): array
    {
        return $this->banned_words;
    }
}
