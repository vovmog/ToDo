<?php
//class requestDb{
//const DB_name ="timesheet";
//const USER = "root";
//const PASS = "";
//const SERVER = "openserver";
//protected $DbConn;
//protected $safe_sql;
//function __construct(){
//    $this->DbConn = new mysqli(self::SERVER,self::USER,self::PASS,self::DB_name);
//    }
//    public function safe($sql) {
//        $this->safe_sql = trim(strip_tags($this->DbConn->real_escape_string($sql)));
//        return $this->safe_sql;
//    }
//    public function request($sql,$in=FALSE){
//        $res = $this->DbConn->query($sql);
//        if($in){
//            $res_arr = array();
//            $res_arr = $res->fetch_all(MYSQLI_ASSOC);
//            /* while ($row = $res->fetch_assoc()) {
//                $res_arr[] = $row;
//            }*/
//            return $res_arr;
//        }else return $res;
//    }
//    public function __destruct(){
//        $this->DbConn->close();
//    }
//}
//$test = new requestDb();
//$name=$test->safe("Vasya");
//$work=$test->safe("zorya");
//
//$sql="SELECT name,work FROM temp WHERE id='1'";
//$result = $test->request($sql,TRUE);
//echo "<pre>";print_r($result); echo "</pre>";
?>

