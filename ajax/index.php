<?php
require_once('./SQL/sql_request.php');

if (isset($_GET['place'])) {
    $sql = "SELECT id,name FROM workplace";
    $res = request($sql);
    $arr_name = res_assoc($res);
    echo json_encode($arr_name);
}
if (isset($_GET['worker'])) {
    $name_arr = stripslashes($_GET["name"]);
    $sql = "SELECT id,name FROM name WHERE name NOT IN ($name_arr)";
    $res = request($sql);
    $arr_name = res_assoc($res);
    echo json_encode($arr_name);
}
?>