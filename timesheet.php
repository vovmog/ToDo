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


$sql = "SELECT DISTINCT id_name FROM timesheet WHERE month='$month' AND year='$year' ORDER BY id_name";
$res = request($sql);
$result_name = mysql_getcolumn($res); //$result_id = $res->fetch_assoc();
$sql = "SELECT id,name FROM name ORDER BY id";
$res = request($sql);
$id_name = mysql_getcolumn($res, TRUE);
$str_month = explode("_", $month_of_the_year);
?>

</head>



<h2> <? echo rus_month($month) . " " . $year ?> </h2>
<select name="name_of_th_month" id="name_of_the_month" onchange="select_month()">
    <?php
    $sql = "SELECT DISTINCT month,year FROM timesheet";
    $res = request($sql);
    $result = res_assoc($res);
    $chk=1;
    if(in_array('January',$result[0])){
        echo "HELLO!!!!";
    };
    foreach ($result as $key => $val) {
        echo "<option value=$val[month]" . "_" . $val[year] . " ";
        if ($val[month] == $month AND $val[year] == $year) {
            echo "selected";
            $chk=0;
        }
        echo ">" . rus_month($val[month]) . " " . $val[year];
        echo "</option>";
    }
    if($chk) echo "<option value ".$month."_".$year." selected>" . rus_month($month) . " " . $year."</option>";

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
    for ($i = 0; $i < count($result_name); $i++) {
        $sql = "SELECT day,workplace,hourse,comment FROM timesheet WHERE id_name='$result_name[$i]' AND month='$month' AND year='$year'";
        $res = request($sql);
        $result_month = res_assoc($res);
        echo "<tr id='name_" . $result_name[$i] . "'>";
        echo "<td class='name'>" . $id_name[$result_name[$i]] . "</td>";
        for ($x = 1; $x <= $count_day; $x++) {
            echo "<td class='hours'>";
            foreach ($result_month as $index => $val) {
                if ($val[day] == $x) {

                    echo "<span class='hourse' title='" . $arr_workplace[$val[workplace]] . "'>" . $val[hourse] . "</span>" . "</br>" . "<span class='workplace'>" . $arr_workplace[$val[workplace]] . "</span>\n";

                } else {

                }
            }
            echo "</td>\n";
        }
        echo "</tr>\n";
    }
    ?>
</table>
<button onclick="add_worker()" id="add_worker">добавить работника</button>
