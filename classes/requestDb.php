<?php
class requestDb{
    const DB_name ="timesheet";
    const USER = "root";
    const PASS = "";
    const SERVER = "openserver";
    public  $DbConn;
    public  $safe_sql;
    function __construct(){
        $this->DbConn = new mysqli(self::SERVER,self::USER,self::PASS,self::DB_name);
        $this->DbConn->set_charset("utf8");
    }
    public function safe($sql) {
        $this->safe_sql = trim(strip_tags($this->DbConn->real_escape_string($sql)));
        return $this->safe_sql;
    }
    public function request($sql,$in='in'){//
        $res = $this->DbConn->query($sql);
        if($in=='out'){
            $res_arr = array();
            $res_arr = $res->fetch_all(MYSQLI_ASSOC);
            /* while ($row = $res->fetch_assoc()) {
                $res_arr[] = $row;
            }*/
            return $res_arr;
        }else return $res;
    }
    public function __destruct(){
        $this->DbConn->close();
    }
}