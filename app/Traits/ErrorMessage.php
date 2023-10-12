<?php

namespace App\Traits;

trait ErrorMessage
{
    public function check($value = null,$success = null,$error = 'could not make this action'){
        if($value){
        return toast($success,'success');
        }
    return toast($error,'error');
    }

}
