<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\producto;
use App\Models\cpcu;
use App\Models\saclap;

class ValidateInformacionProducto implements Rule
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

        if(!$value){
            return true;
        }
        $cpcu = cpcu::where('codigo', $value)->get();
        $saclap = saclap::where('codigo', $value)->get();

        if(count($saclap) > 0 || count($cpcu) > 0){
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El codigo :input no se encuentra en la base de datos cerca de: :attribute.';
    }
}
