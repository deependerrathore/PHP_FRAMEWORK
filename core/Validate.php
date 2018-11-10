<?php

class Validate{
    private $_passed = false, $_errors = [] , $_db = null;

    public function __construct(){
        $this->_db  = DB::getInstance();
    }

    /**
    * $_POST,[
    *              'username' =>[
    *                    'display' =>"Username",
    *                    'required' => true
    *                ],
    *                'password' => [
    *                    'display' => "Password",
    *                    'required' => true
    *                ]
    *            ]
     */
    public function check($source, $items = []){
        $this->_errors = [];
        foreach($items as $item => $rules){
            $item = Input::sanatize($item);
            $display = $rules['display'];
            foreach($rules as $rule => $rule_value){
                $value = Input::sanatize(trim($source[$item]));

                if($rule === 'required' && empty($value)){
                    $this->addError(["{$display} is required",$item]);
                }elseif(!empty($value)){
                    switch($rule){
                        case 'min':
                        if(strlen($value) < $rule_value){
                            $this->addError(["{$display} must be of {$rule_value} characters",$item]);
                            break;
                        }
                        case 'max':
                        if(strlen($value) > $rule_value){
                            $this->addError(["{$display} must be maximum of {$rule_value} characters",$item]);
                            break;
                        }
                    }
                }
            }
        }
    }

    public function addError($error){
        $this->_errors[] = $error;
        if (empty($this->_errors)) {
            $this->_passed = true;
        }else{
            $this->_passed = false;
        }
    }
}