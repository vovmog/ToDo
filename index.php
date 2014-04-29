<?php
error_reporting (E_ALL);

require_once("./init.php");

if ($user_obj->role == "guest") {
    require_once("show_table.php");
    exit();
}
if (isset($_GET["ajax"])) {
    require_once("./ajax/index.php");
    exit();
}
if (isset($_GET["change"])) {
    require_once("./change.php");
    exit();
    }
if (isset($_GET["gr_change"])) {
    require_once("./gr_change.php");
    exit();
}
////////////// Включение библиотек и сторонних файлов //////////////////////////
require_once('./SQL/sql_request.php');
require_once('head.tmpl'); ///Вставляем Head html блока
//////////////////////////////////////////////////////////////////////////////
//////////////////Проверка последнего записанного дня недели/////////////

$day = (date("d"));
$month = date("F");
$year = date("Y");
$sql = "SELECT DISTINCT day FROM timesheet WHERE day = '$day' AND month ='$month'";
$res = request($sql);
$result = res_assoc($res);
$sql="SELECT day_of_year FROM chk_day WHERE day_of_year = '".$day."_".$month."_".$year."'";
$res = request($sql);
$res_chk = res_assoc($res);

if (!empty($result) or !empty($res_chk)) { ////Если текущая дата уже была записана то пропускаем блок для заполнения табеля
    require_once("timesheet.php");

} else { ////Иначе вставляем блок записи табеля
    require_once('timesheet_insert.tmpl');
}
//require_once('./admin/edit.php');
echo $user_obj->login;
require_once('footer.tmpl');