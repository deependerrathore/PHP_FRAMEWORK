<?php

class Followers extends Model{
    public function __construct(){
        $table = 'followers';
        parent::__construct($table);
    }
}