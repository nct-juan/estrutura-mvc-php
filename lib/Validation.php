<?php

namespace lib;

class Validation
{

    public function __construct(){}

    public function validationObj($value, $mod)
    {
        if($mod == "email")
        {
            return filter_var($value,FILTER_VALIDATE_EMAIL);     
        }
        else if($mod == "int")
        {
            return filter_var($value,FILTER_VALIDATE_INT);
        }
        else if($mod == "string")
        {
            return filter_var($value,FILTER_SANITIZE_STRING);
        }
    }


}