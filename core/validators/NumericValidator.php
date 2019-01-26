<?php 

class NumericValidator extends CustomValidator{

    public function runValidation(){
        $value = $this->_model->{$this->field};
        if (!empty($value)) {
            return (is_numeric($value)) ? true : false;
        }
        return false;
    }
}