<?php

class Notifications extends Model{
    public function __construct(){
        $table = 'notifications';
        parent::__construct($table);
    }

    public function insertNotification($username,$notificationArray){
        $receiver = new Users($username);
        $this->type = $notificationArray['type'];
        $this->sender = currentUser()->id;
        $this->receiver = $receiver->id;
        $this->extra = $notificationArray['extra'];
        $this->save();
    }
}