<?php

namespace App\Rules;

use App\Models\Promocode;
use Illuminate\Contracts\Validation\Rule;

class PromocodeValidationRule implements Rule
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
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $promoCode = Promocode::where([
            ['code', '=', $value],
            ['is_active', '=', true],
            ['start_at', '<', now()],
            ['end_at', '>', now()],
        ])->first();
        return !!$promoCode;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The promocode is not valid.';
    }
}
