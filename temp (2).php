<?php
require_once('./SQL/sql_request.php');


$sql = "SELECT * FROM 1_NOVEMBER_2012";
$res = request($sql);
if (!$res) {
    $result_name = 0;
} else {
    $result_name = res_assoc($res);
}
echo ($res->num_rows);
echo "<br/>";
print_r($result_name);
echo"<br/>";
var_dump($res);

?>