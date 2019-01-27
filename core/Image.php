<?php

namespace Core;
class Image{

    /**
     * This method is used to upload image
     * @params $_FILES
     * @params filename
     * method will return the link that can be stored in database
     */
    public static function uploadImage($file,$name){
        
            $image = base64_encode(file_get_contents($file[$name]['tmp_name']));
            $options = array('http'=>array(
                'method' =>"POST",
                'header' => "Authorization: Bearer f9bae1a2c4683f2b7fe53b0c00bbc72f3a92ba7b\n".
                "content-type: application/x-www-form-urlencoded",
                'content' => $image

            ));
            $context = stream_context_create($options);
            $imageURL = "https://api.imgur.com/3/image";
            $response = file_get_contents($imageURL ,false,$context);

            $response = json_decode($response);

            $link = $response->data->link;

            return $link;
    }
}