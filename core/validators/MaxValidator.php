<?php

namespace Core\Validators;
use Core\Validators\CustomValidator;
class MaxValidator extends CustomValidator{
    public function runValidation(){
        $value = $this->_model->{$this->field};
        return (strlen($value) <= $this->rule) ? true : false;
    }
}