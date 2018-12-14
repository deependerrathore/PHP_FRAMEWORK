<?php

function inputBlock($type , $label,$name,$value= '' , $placeholder ,$divAttrs=[],$labelAttrs=[],$inputAttrs=[]){
    $divString = stringfyAttrs($divAttrs);
    $inputString = stringfyAttrs($inputAttrs);
    $labelString = stringfyAttrs($labelAttrs);
    $html = '<div ' . $divString . '>';
    $html .= '<label '. $labelString .' for="'.$name.'">'.$label. '</label>';
    $html .= '<div class="control">';
    $html .= '<input type="'.$type.'" name="'.$name.'" id="'.$name.'" value="'.$value.'" placeholder="'. $placeholder.'" ' . $inputString. '/>';
    $html .= '</div>';
    $html .= '<div>';
    return $html;
}

function submitTag($buttonText,$divAttrs1=[],$divAttrs2 = [],$inputAttrs=[]){
    $inputString = stringfyAttrs($inputAttrs);
    $divString1 = stringfyAttrs($divAttrs1);
    $divString2 = stringfyAttrs($divAttrs2);
    $html = '<div '.$divString1. '>';
    $html .= '<div '.$divString2. '>';
    $html .= '<button type="submit" value="'. $buttonText.'" ' . $inputString. '>'.$buttonText.'</button>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;
}
function stringfyAttrs($attrs){
    $string = '';
    foreach($attrs as $key => $value){
        $string .= $key . '="' .$value . '"'; 
    }

    return $string;
}