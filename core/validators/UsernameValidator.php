<?php

namespace Core\Validators;
use Core\Validators\CustomValidator;
class UsernameValidator extends CustomValidator{

    public function runValidation(){
        $username = $this->_model->{$this->field};
        if (!empty($username)) {
            return (preg_match('/^[a-zA-Z0-9_]+$/',$username)) ? true: false;     
        }
        return false;
    }
    
}