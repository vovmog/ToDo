<?php
require_once('./SQL/sql_request.php');

$day = $_GET['day'];

//////////////// Проверка последнего месца БД ////////////////////////////////
$month_of_year = (date("F_Y"));
$month = date("F");
$year = date("Y");
/*
$sql = "SELECT month from timesheet WHERE month = '$month_of_year'";
$res = request($sql);
$result = res_assoc($res);
if (!$result[0]) {
 /// если нет текущего месяца то добавляем его в таблицу /////////////
    $sql = "INSERT INTO month (name_of_the_month) value ('$month_of_year')";
    $res = request($sql);
    $day = (date('d'));
    $sql = "DELETE from day";
    $res = request($sql);
    $sql = "CREATE TABLE IF NOT EXISTS $month_of_year (user_id INT NOT NULL )";
    $res = request($sql);
}
*/

$sql = "SELECT DISTINCT id_name FROM timesheet WHERE month='$month'";
$res = request($sql);
$result_user_id_arr = mysql_getcolumn($res); //$result_user_id_arr = $res->fetch_assoc();//Получение списка имен в определенном месяце
if (!$result_user_id_arr) $result_user_id_arr = Array();
//Получение массива данных начиная совторой позиции

$arr_ins = array_slice($_GET, 3);

foreach ($arr_ins as $key => $value) {
    $arr_key = explode("_", $key); //разбиваем строку по разделителю _
    $arr_insert[$arr_key[0]][$arr_key[1]] = $value;
}
if (is_array($arr_insert)) {
    foreach ($arr_insert as $id => $value) {
        $table = $id . "_" . $month_of_year;
        // echo "<pre>"; print_r($result_user_id_arr); echo "</pre>";
        //echo "<pre>"; print_r($month_of_year); echo "</pre>";


        //  if (!(in_array($id,$result_user_id_arr))){
        //$sql = "CREATE TABLE IF NOT EXISTS " .$id."_".$month_of_year."(date tinyint(4) NOT NULL,workplace char(40) NOT NULL,hours tinyint(4) NOT NULL, comment text NOT NULL)";
        //$res = request($sql);
        //$sql ="INSERT INTO $month_of_year (user_id) VALUES ($id)";
        // $res = request($sql);
        // }

        $sql = "INSERT INTO timesheet (id_name, day, month, year, workplace, hourse, comment) VALUES ('$id', '$day', '$month', '$year', '$value[Place]', '$value[hours]' ,'$value[comment]')";
        $res = request($sql);

    }
} else {
    header('Location: ' . "index.php");
}
$sql = "INSERT INTO day (day) VALUE ('$day')";
$res = request($sql);
header('Location: ' . "index.php");
exit;
