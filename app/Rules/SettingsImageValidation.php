<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Validation\Concerns\ValidatesAttributes;

class SettingsImageValidation implements InvokableRule
{
    use ValidatesAttributes;

    /**
     * The allowed dimensions mime types.
     *
     * @var array<mixed>
     */
    protected array $mimes = [];

    /**
     * Create a new dimensions rule instance.
     *
     * @param  array<mixed>  $mimes
     * @return void
     */
    public function __construct(array $mimes = [])
    {
        $this->mimes = $mimes;
    }

    /**
     * Set the mime types.
     *
     * @param  array<mixed>  $value
     * @return $this
     */
    public function mimes($value)
    {
        $this->mimes = $value;

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return bool
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (is_string($value) && ! empty($value)) {
            return true;
        }

        if (! $this->validateImage($attribute, $value)) {
            $fail(__('validation.image'));

            return false;
        }

        if (count($this->mimes) && ! $this->validateMimes($attribute, $value, $this->mimes)) {
            $fail(__('validation.image_type', ['mimes' => implode(', ', $this->mimes)]));

            return false;
        }

        return true;
    }
}
