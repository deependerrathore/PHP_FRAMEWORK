<?php

namespace App\Models;
use Core\Model;
use App\Models\Users;
class Notifications extends Model{
    public $id,$type,$receiver,$sender,$extra;
    public function __construct(){
        $table = 'notifications';
        parent::__construct($table);
    }

    public function insertNotification($user,$notificationArray){
        $receiver = new Users($user);
        $this->type = $notificationArray['type'];
        $this->sender = Users::currentUser()->id;
        $this->receiver = $receiver->id;
        $this->extra = $notificationArray['extra'];
        $this->save();
    }
}