<?php

namespace App\Rules;

use App\Models\actividad;
use Illuminate\Contracts\Validation\Rule;
use App\Models\producto;
use App\Models\cpcu;
use App\Models\entidad;
use App\Models\saclap;
use App\Models\nae;

class ValidateActividadesProducto implements Rule
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
        // dd(explode( '/', $value ));
        if(!$value){
            return true;
        }
        $codsArray = explode( '/', $value );
        if(count($codsArray) === 0){
            return true;
        }
        $findAll = true;
        for ($i=0; $i < count($codsArray); $i++) {
           $actividad = actividad::where('codigo', $codsArray[$i])->get();
           if(count($actividad) === 0){
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
        return 'Uno de estos códigos de las actividades :input no se encuentran registrados en la base de datos cerca de :attribute.';
    }
}
