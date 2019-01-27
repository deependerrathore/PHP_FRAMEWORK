<?php 

namespace Core\Validators;
use Core\Validators\CustomValidator;
class EmailValidator extends CustomValidator{
    public function runValidation(){
        $email = $this->_model->{$this->field};
        if (!empty($email)) {
           return (filter_var($email,FILTER_VALIDATE_EMAIL)) ? true: false;
        }
        
        return false;
    }
}