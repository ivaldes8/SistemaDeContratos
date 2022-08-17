<?php

namespace App\Rules;


use Illuminate\Contracts\Validation\Rule;
use App\Models\indicador;

class ValidateInformacionIndicador implements Rule
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
        $textInd = explode( '/', $value );
        if(count($textInd) === 0){
            return true;
        }
        $findIndicador = true;
        if(count($textInd) > 0){
            $indicador = indicador::where('desc', $textInd[0])->get();
            if(count($indicador) === 0){
                $findIndicador = false;
            }
        }

        if($findIndicador === true){
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
        return 'El indicador especificado no se encuentra en la base de datos';
    }
}
