<?php 

namespace Core;
use Core\Session;
class FH {

    /**
     * Creates an input block to be used in a form
     *
     * @param string $type type of input i.e text , password ,phone
     * @param string $label The label that will be used for input
     * @param string $name the id and name of the input will be set to this value
     * @param string $value (optional) The value of the input
     * @param string $placeholder placeholder for the text box
     * @param array $divAttrs (optional) attributes of the surrounding div
     * @param array $labelAttrs (optional) attributes of the surrouding lable
     * @param array $inputAttrs (optional) attributes of the input
     * @param array $errors (optional) array of all errors
     * @return string returns an html string for input block
     */
    public static function inputBlock($type , $label,$name,$value= '' , $placeholder ,$divAttrs=[],$labelAttrs=[],$inputAttrs=[],$errors=[]){
        $inputAttrs = self::blockErrors($inputAttrs,$errors,$name);
        //if(!empty($errors)) H::dnd($inputAttrs);
        $divString = self::stringfyAttrs($divAttrs);
        $inputString = self::stringfyAttrs($inputAttrs);
        $labelString = self::stringfyAttrs($labelAttrs);
        $html = '<div ' . $divString . '>';
        $html .= '<label '. $labelString .' for="'.$name.'">'.$label. '</label>';
        $html .= '<div class="control">';
        $html .= '<input type="'.$type.'" name="'.$name.'" id="'.$name.'" value="'.$value.'" placeholder="'. $placeholder.'" ' . $inputString. '/>';
        $html .= '<span class="help is-danger">'. self::errorMsg($errors,$name).' </span>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }
    
    public static function submitTag($buttonText,$divAttrs1=[],$divAttrs2 = [],$inputAttrs=[]){
        $inputString = self::stringfyAttrs($inputAttrs);
        $divString1 = self::stringfyAttrs($divAttrs1);
        $divString2 = self::stringfyAttrs($divAttrs2);
        $html = '<div '.$divString1. '>';
        $html .= '<div '.$divString2. '>';
        $html .= '<button type="submit" value="'. $buttonText.'" ' . $inputString. '>'.$buttonText.'</button>';
        $html .= '</div>';
        $html .= '</div>';
        
        return $html;
    }
    public static function stringfyAttrs($attrs){
        $string = '';
        foreach($attrs as $key => $value){
            $string .= $key . '="' .$value . '"'; 
        }
        
        return $string;
    }
    
    public static function generateToken(){
        $token = base64_encode(openssl_random_pseudo_bytes(32));
        Session::set('csrf_token',$token);
        return $token;
    }
    
    public static function checkToken($token){
        return (Session::exists('csrf_token') && Session::get('csrf_token') == $token);
    }
    
    public static function csrfInput(){
        return '<input type="hidden" name="csrf_token" id="csrf_token" value="'.self::generateToken().'" />';
    }
    
    public static function sanatize($dirtyValue){
        return htmlentities($dirtyValue,ENT_QUOTES,'UTF-8');
    }
    
    
    public static function posted_values($post){
        $clean_ary = [];
        foreach($post as $key => $value){
            $clean_ary[$key] = sanatize($value);
        }
        
        return $clean_ary;
    }

    public static function displayErrors($errors){  
        $html = '<ul class="menu-list">';
        foreach ($errors as $field => $error) {
            $html .= '<li class="has-text-danger">' . $error . '</li>';
            $html .= '<script>jQuery("document").ready(function(){jQuery("#' . $field . '").addClass("is-danger")});</script>';
        }
         $html .= '</ul>';
         return $html;
    }


    /**
     * Adds a class to the surrounding input array if there are errors. This is used to style the form elements
     *
     * @param  array $inputAttr default input attributes array  
     * @param array $errors passed in the form errors
     * @param string $name name of the field
     * @return array
     */
    public static function blockErrors($inputAttr ,$errors,$name){
        if (array_key_exists($name,$errors)) {
           if (array_key_exists('class',$inputAttr)) {
               $inputAttr['class'] .= " is-danger";
           }else{
               $inputAttr['class'] = "is-danger";
           }
        }

        return $inputAttr;
    }

    /**
     * Returns an error message for the input
     *
     * @param array $errors pass in the form errors
     * @param string $name id and name of the input
     * @return string returs the error message from the form error
     */
    public static function errorMsg($errors,$name){
        $msg = (array_key_exists($name,$errors)) ? $errors[$name] : "";
        return $msg;
    }
}