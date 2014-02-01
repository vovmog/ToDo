<?php


class user{
    public $user_id;
    public $role;
    public $sesId;
    public $name;
    public $login;
    public $time_reg;


    function __construct(){
        $user = new authentication();
        $this->user_id = $user->user_id;
        $this->login = $user->user_login;
        $this->role = $user->role;
        $this->time_reg = $user->time_reg;
    }
    public function get_data(){

    }
    public  function getClass(){
        echo  __CLASS__;
    }
}
