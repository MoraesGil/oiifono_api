<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class Option implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Validator::make($value, [
            'label' => 'nullable|string|max:100',
            'group' => 'sometimes|numeric',
            'options' => 'sometimes|array',
            'options.*' => [new Option]
        ])->passes();
        
        
    }

    /**
     * Get the validaWtion error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Não é uma opção válida.';
    }
}
