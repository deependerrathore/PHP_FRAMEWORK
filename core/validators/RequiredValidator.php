<?php 

namespace Core\Validators;
use Core\Validators\CustomValidator;
class RequiredValidator extends CustomValidator{
    public function runValidation(){
        $value = $this->_model->{$this->field};
        return (!empty($value) || !isset($value)) ? true : false;
    }
}