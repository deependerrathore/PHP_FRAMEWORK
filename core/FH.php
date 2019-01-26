<?php 

class FH {

    /**
     * type , label , name, value , placeholder, div attributes , label attribute and input attributes
     */
    public static function inputBlock($type , $label,$name,$value= '' , $placeholder ,$divAttrs=[],$labelAttrs=[],$inputAttrs=[]){
        $divString = self::stringfyAttrs($divAttrs);
        $inputString = self::stringfyAttrs($inputAttrs);
        $labelString = self::stringfyAttrs($labelAttrs);
        $html = '<div ' . $divString . '>';
        $html .= '<label '. $labelString .' for="'.$name.'">'.$label. '</label>';
        $html .= '<div class="control">';
        $html .= '<input type="'.$type.'" name="'.$name.'" id="'.$name.'" value="'.$value.'" placeholder="'. $placeholder.'" ' . $inputString. '/>';
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
}