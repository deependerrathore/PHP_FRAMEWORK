<?php

class Notifications extends Model{
    public function __construct(){
        $table = 'notifications';
        parent::__construct($table);
    }

    public function insertNotification($username,$notificationType){
        $receiver = new Users($username);
        $this->type = $notificationType;
        $this->sender = currentUser()->id;
        $this->receiver = $receiver->id;
        $this->save();
    }
}