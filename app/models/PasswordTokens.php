<?php

class PasswordTokens extends Model{
    public function __construct(){
        $table = 'password_tokens';
        parent::__construct($table);    
    }

    public static function savePasswordToken($userid){
        $passwordTokenObj = new self();
        $cstrong = TRUE;
        $token =  bin2hex(openssl_random_pseudo_bytes(64,$cstrong));
        $fields = [
            'token' => sha1($token),
            'user_id' => $userid
        ];
        $passwordTokenObj->insert($fields);
    }
}