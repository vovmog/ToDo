<?php
require_once('./SQL/sql_request.php');
require_once('func.php');
require_once('head.tmpl');


$sql = "SELECT id,name FROM workplace";
$res = request($sql);
$result_workplace = res_assoc($res);
foreach ($result_workplace as $index => $val) {
    $arr_workplace[$val['id']] = $val['name'];
}
if (isset($_GET["month_of_year"])) {
    $str_month = explode("_", $_GET["month_of_year"]);
    $month = $str_month[0];
    $year = $str_month[1];
} else {
    $month = date("F");
    $year = date("Y");
}


/*$sql = "SELECT DISTINCT id_name FROM timesheet WHERE month='$month' AND year='$year' ORDER BY id_name";
$res = request($sql);
$result_name = mysql_getcolumn($res); //$result_id = $res->fetch_assoc();
$sql = "SELECT id,name FROM name ORDER BY id";
$res = request($sql);
$id_name = mysql_getcolumn($res, TRUE);
$str_month = explode("_", $month_of_the_year);*/
$sql = "SELECT id_name,name.name,day,workplace.name AS workplace,hourse,timesheet.comment
        FROM name,timesheet,workplace
        WHERE name.id = timesheet.id_name
        AND workplace.id=timesheet.workplace
        AND month ='$month'
        AND year='$year'
       ";
$result = request($sql);
$res = res_assoc($result);
$user = array();
foreach ($res as $key => $val) {
    $user[$val['name']]['user_id'] = $val['id_name'];
    $user[$val['name']][$val['day']]['workplace'] = $val['workplace'];
    $user[$val['name']][$val['day']]['hourse'] = $val['hourse'];
    $user[$val['name']][$val['day']]['comment'] = $val['comment'];
    $user[$val['name']][$val['day']]['id_name'] = $val['id_name'];
}

?>

</head>



<h2> <? echo rus_month($month) . " " . $year ?> </h2>
<select name="name_of_th_month" id="name_of_the_month" onchange="select_month()">
    <?php
    $sql = "SELECT DISTINCT month,year FROM timesheet";
    $res = request($sql);
    $result = res_assoc($res);
    $chk = 1;
    foreach ($result as $key => $val) {
        echo "<option value=$val[month]" . "_" . $val['year'] . " ";
        if ($val['month'] == $month AND $val['year'] == $year) {
            echo "selected";
            $chk = 0;
        }
        echo ">" . rus_month($val['month']) . " " . $val['year'];
        echo "</option>";
    }
    if ($chk) echo "<option value " . $month . "_" . $year . " selected>" . rus_month($month) . " " . $year . "</option>";

    ?>
</select>
<table border=1 class="table" id="<?echo $month . "_" . $year;     ?>">
    <?php
    echo "<tr class='th'>";
    echo "<td>Имя</td>";
    $count_day = intval(date("t", strtotime($month . " " . $year)));
    for ($i = 1; $i <= $count_day; $i++) {
        echo "<td>$i</td>\n";
    }
    echo "</tr>\n";
    foreach ($user as $name => $day) {
        echo "<tr id='name_" . $day['user_id'] . "'><td class='name'>" . $name . "</td>";
        for ($i = 1; $i <= $count_day; $i++) {
            echo "<td class='hours'>";
            if (array_key_exists($i, $user[$name])) {
                echo "<span class='hourse' title='" . $day[$i]['comment'] . "'>" . $day[$i]['hourse'] . "</span></br>" . "<span class='workplace'>" . $day[$i]['workplace'];
            }
            echo "</td>";
        }
        echo "</tr>";
    }

    ?>
</table>
<?php
if (isset($_COOKIE['cook_name']) == "B_Lock") {
    echo "<button class='btn' onclick='add_worker()' id='add_worker'>добавить работника</button>";
}
?>