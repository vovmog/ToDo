<?php
require_once('./SQL/sql_request.php');
if ($user_obj->role == "admin") {
    if (isset($_GET['place'])) {
        $sql = "SELECT id,name FROM workplace";
        $res = request($sql);
        $arr_name = res_assoc($res);
        echo json_encode($arr_name);
    }
    if (isset($_GET['worker'])) {
        $name_arr = stripslashes($_GET["name"]);
        if($name_arr){
        $sql = "SELECT id,name FROM name WHERE name NOT IN ($name_arr)";
        }else $sql = "SELECT id,name FROM name";
        $res = request($sql);
        $arr_name = res_assoc($res);
        echo json_encode($arr_name);
    }
    if(isset($_GET['add_work'])){
        $DB = new requestDb();
        $work = $DB->safe($_GET['add_work']);
        $sql = "INSERT INTO workplace (name) VALUE ('$work')";
        $res = $DB->request($sql);
        if ($res){
            echo json_encode($work."  Добавлен");
        }else echo json_encode($work."  Ошибка: не добавлен");

    }
    if(isset($_GET['add_workman'])){
        $DB = new requestDb();
        $workman = $DB->safe($_GET['add_workman']);
        $sql = "INSERT INTO name (name) VALUE ('$workman')";
        $res = $DB->request($sql);
        if ($res){
            echo json_encode($workman."  Добавлен");
        }else echo json_encode($workman."  Ошибка: не добавлен");


    }

}
