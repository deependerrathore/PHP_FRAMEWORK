<?php

namespace Core;

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
    public function check($source, $items = [],$csrfCheck=false){
        $this->_errors = [];
        if ($csrfCheck) {
            $csrfPass = FH::checkToken($source['csrf_token']);
            if(!isset($source['csrf_token']) || !$csrfPass){
                $this->addError(["Something has gone wrong",'csrf_token']);
            }
        }
        foreach($items as $item => $rules){
            $item = FH::sanatize($item);
            $display = $rules['display'];
            foreach($rules as $rule => $rule_value){
                $value = FH::sanatize(trim($source[$item]));

                if($rule === 'required' && empty($value)){
                    $this->addError(["{$display} is required",$item]);
                }elseif(!empty($value)){
                    switch($rule){
                        case 'min':
                        if(strlen($value) < $rule_value){
                            $this->addError(["{$display} must be of {$rule_value} characters",$item]);
                        }
                        break;

                        case 'max':
                        if(strlen($value) > $rule_value){
                            $this->addError(["{$display} must be maximum of {$rule_value} characters",$item]);
                        }
                        break;
                        case 'matches':
                        if($value != $source[$rule_value]){//eg . confirm text field value != $_POST['password']
                            $matchDisplay = $items[$rule_value]['display'];
                            $this->addError(["{$matchDisplay} and {$display} must match.",$item]);
                        } 
                        break;
                        case 'not_matches'://This needs to be changed so that first we will verfy the last saved password
                        if($value == $source[$rule_value]){
                            $matchDisplay = $items[$rule_value]['display'];
                            $this->addError(["{$matchDisplay} and {$display} should not match.",$item]);
                        } 
                        break;
                        case 'unique':
                        $check = $this->_db->query("SELECT {$item} FROM {$rule_value} WHERE {$item} = ?",[$value]);
                        if($check->count()){
                            $this->addError(["{$display} already exists. Please choose another {$display}",$item]);
                        }
                        break;
                        case 'unique_update':
                        $t = explode(',',$rule_value);
                        $table = $t[0];
                        $id = $t[1];
                        $query = $this->_db->query("SELECT * FROM {$table} WHERE id != ? AND {$item} = ? " , [$id, $value]); 
                        if($query->count()){
                            $this->addError(["{$display} already exists. Please choose another {$display}.",$item]);
                        }
                        break;
                        case 'is_numeric':
                        if(!is_numeric($value)){
                            $this->addError(["{$display} has to be number. Please use a numeric value.",$item]);
                            
                        }
                        break;
                        case 'valid_email':
                        if(!filter_var($value,FILTER_VALIDATE_EMAIL)){
                            $this->addError(["{$display} must be a right email address.",$item]);
                        }
                        break;
                        case 'valid_username':
                        if(!preg_match('/^[a-zA-Z0-9_]+$/',$value)){
                            $this->addError(["{$display} must be valid. only _ is acceptable as special character.",$item]);
                        }
                        break;
                    }
                }
            }
        }

        if(empty($this->_errors)){
            $this->_passed = true;
        }

        return $this;
    }

    public function addError($error){
        $this->_errors[] = $error;
        if (empty($this->_errors)) {
            $this->_passed = true;
        }else{
            $this->_passed = false;
        }
    }

    public function errors()
    {
        return $this->_errors;
    }
     public function passed()
    {
        return $this->_passed;
    }

    public function displayErrors(){   
        $html = '<ul class="menu-list">';
        foreach ($this->_errors as $error) {
            if (is_array($error)) {
                $html .= '<li class="has-text-danger">' . $error[0] . '</li>';
                $html .= '<script>jQuery("document").ready(function(){jQuery("#' . $error[1] . '").addClass("is-danger")});</script>';
            } else {
                $html .= '<li class="has-text-danger">'.$error.'</li>';
            }
        }
         $html .= '</ul>';
         return $html;
    }
}