<?php

class PasswordTokens extends Model{
    public $id,$token,$user_id;
    public function __construct(){
        $table = 'password_tokens';
        parent::__construct($table);    
    }

    public function savePasswordToken($userid){
        $cstrong = TRUE;
        $token =  bin2hex(openssl_random_pseudo_bytes(64,$cstrong));

        //mail() Have to send mail from here
        $fields = [
            'token' => sha1($token),
            'user_id' => $userid
        ];
        $this->insert($fields);

        return $token;
    }
}