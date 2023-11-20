<?php


/*namespace App\Helpers;
use Illuminate\Validation\Validator;

class MY_Validation extends Validator
{
    function UniqueDb($attribute, $value, $parameters, $validator){
        dd($parameters);
        $exist = \DB::table($parameters[0])->where($parameters[1], '<>', $parameters[2])->where($attribute, $value)->select($parameters[1])->exists();
        return !$exist;

    }
}*/
