<?php

namespace App\Rules;

use App\Models\actividad;
use Illuminate\Contracts\Validation\Rule;
use App\Models\producto;
use App\Models\cpcu;
use App\Models\entidad;
use App\Models\saclap;
use App\Models\nae;

class ValidateInformacionEntidad implements Rule
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
        $entidadREU = entidad::where('codREU', $value)->get();
        $entidadNIT = entidad::where('codNIT', $value)->get();
        if(count($entidadREU) > 0 || count($entidadNIT) > 0){
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
        return 'El código REU o NIT :input no se encuentra asociado a ninguna entidad en la base de datos cerca de: :attribute.';
    }
}
