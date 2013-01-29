<?php
require_once('./SQL/sql_request.php');


$name = $_REQUEST["name"];
$day = $_REQUEST["day"];
$hours = $_REQUEST["hours"];
$workplace = $_REQUEST["workplace"];
$month_of_year = explode(" ", $_REQUEST["month"]);
$month = $month_of_year[0];
$year = $month_of_year[1];
if(isset($_REQUEST["del"]))$del = $_REQUEST["del"];else $del= false;
$id_month = $name . "_" . $month;

$sql = "SELECT  hourse FROM timesheet
            WHERE id_name='$name'
            AND day='$day'
            AND month='$month'
            AND year='$year'";
$res = request($sql);
$result = res_assoc($res);

$sql = "SELECT DISTINCT id_name FROM timesheet
            WHERE id_name='$name'";
$res = request($sql);
$result_user_id_arr = $res->fetch_assoc();
if (!$result_user_id_arr) $result_user_id_arr = Array();

if (count($result)) {
    if (!$del) {
        $sql = "UPDATE timesheet SET hourse='$hours' ,workplace = '$workplace'
                    WHERE id_name='$name'
                    AND day='$day'
                    AND month='$month'
                    AND year='$year'";
        $res = request($sql);
    } else {
        $sql = "DELETE FROM timesheet
                    WHERE id_name='$name'
                    AND day='$day'
                    AND month='$month'
                    AND year='$year'";
        $res = request($sql);
        header('Location: ' . "/.");
    }
} else {
    if (!$del) {
        $sql = "INSERT INTO timesheet
                    (id_name,
                     day,
                     month,
                     year,
                     hourse,
                     workplace)
                 VALUES
                    ('$name',
                     '$day',
                     '$month',
                     '$year',
                     '$hours',
                     '$workplace')";
        $res = request($sql);

    }
}
$str = $month . "_" . $year;
header('Location: ' . "index.php?month_of_year=$str");
echo ("Имя = " . $name . "</br>число = " . $day . "</br>часы = " . $hours . "<br/>обьект = " . $workplace . "</br>месяц =" . $month . "</br>" . $id_month);
