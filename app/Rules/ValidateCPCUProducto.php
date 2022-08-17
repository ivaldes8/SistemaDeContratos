<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\cpcu;

class ValidateCPCUProducto implements Rule
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
        $codsArray = explode( ',', $value );
        if(count($codsArray) === 0){
            return true;
        }
        $findAll = true;
        for ($i=0; $i < count($codsArray); $i++) {
           $cpcu = cpcu::where('codigo', $codsArray[$i])->get();
           if(count($cpcu) === 0){
               $findAll = false;
           }
        }
        if($findAll === true){
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
        return 'Uno de estos códigos de cpcu :input no se encuentran registrados en la base de datos cerca de :attribute.';
    }
}
