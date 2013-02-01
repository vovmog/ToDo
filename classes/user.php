<?php


class user{
    public $user_id;
    public $role;
    public $cook_id;
    public $sesId;
    public $name;
    public $login;
    public $email;
    public $phpSID;

    function __construct(){
         if(isset($_GET['login']) and isset($_GET['password']) and !empty($_GET['login'])and !empty($_GET['password'])){
             $dbConn = new requestDb();
             $l = $dbConn->safe($_GET['login']);
             $sql = "SELECT id, psw FROM user WHERE login = '".$l."'";
             $result = $dbConn->request($sql,TRUE);
             $chk_login = $dbConn->DbConn->affected_rows;
             if($chk_login){
                 $psw = $result[0]['psw'];
                 $id =$result[0]['id'];
                 if($psw === $_GET['password']){
                     $_SESSION['id']=$id;
                     setcookie('id',$id);
                     $this->user_id= $id;
                     $this->role="user";
                     $_SESSION['role']= $this->role;
                     $_SESSION['name']="Vasja";
                     $_SESSION['login']=$_GET['login'];
                     echo "HELLO!";
                 }else echo "Wrong login or password";
             }else echo "Wrong login or password";

         }elseif(!isset($_SESSION['id']) or !isset($_COOKIE['id']) or $_SESSION['id'] !== $_COOKIE['id']){
            session_destroy();
            $_SESSION['id']="0";
            setcookie('id','0');
            $this->user_id= "0";
            $this->role="guest";
        }else {
            $this->cook_id = $_COOKIE['id'];
            $this->phpSID = $_SESSION['id'];
            $this->user_id = $_SESSION['id'];
            $this->name = $_SESSION['name'];
            $this->role = $_SESSION['role'];
            $this->login = $_SESSION['login'];
        }


    }
    public  function getClass(){
        echo  __CLASS__;
    }
}
