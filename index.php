<?php
if (!$_COOKIE['cook_name'] == "B_lock" or isset($_GET["show_table"])) {
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
////////////// Включение библиотек и сторонних файлов //////////////////////////
require_once('./SQL/sql_request.php');
require_once('head.tmpl'); ///Вставляем Head html блока
//////////////////////////////////////////////////////////////////////////////
//////////////////Проверка последнего записанного дня недели/////////////

$day = (date("d"));
$month = date("F");
$sql = "SELECT DISTINCT day FROM timesheet WHERE day = '$day' AND month ='$month'";
$res = request($sql);
$result = res_assoc($res);

if ($result[0]) { ////Если текущая дата уже была записана то пропускаем блок для заполнения табеля
    require_once("timesheet.php");

} else { ////Иначе вставляем блок записи табеля
    require_once('timesheet_insert.tmpl');
}
require_once('./admin/edit.php');
require_once('footer.tmpl');
?>