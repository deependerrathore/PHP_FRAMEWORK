<?php

namespace Core\Validators;
use Core\Validators\CustomValidator;
class MinValidator extends CustomValidator{
    public function runValidation(){
        $value = $this->_model->{$this->field};
        return (strlen($value) >= $this->rule) ? true : false;
    }
}