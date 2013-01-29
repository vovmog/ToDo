<?php
require_once('./SQL/sql_request.php');
require_once('func.php');
$sql = "SELECT  COUNT(DISTINCT id_name) FROM timesheet WHERE month ='January' AND year='2013'";
$result1 = request($sql);
$sql = "SELECT  id_name,day,workplace,hourse FROM timesheet  WHERE month ='January' AND year='2013' GROUP BY day";
$result = request($sql);
$res = res_assoc($result);
$sql = "SELECT ";
echo "<pre>";print_r (res_assoc($result1));echo"</pre>";
echo "<pre>";print_r ($res);echo"</pre>";
//$arr = array('user_1'=> array('1_day' => array('workplace' => '1_place','hourse' =>8),
//                            '2_day' =>array('workplace' => '1_place','hourse' =>8)),
//            'user_2'=> array('1_day' => array('workplace' => '1_place','hourse' =>8),
//                             '2_day' =>array('workplace' => '1_place','hourse' =>8)));
//echo "<pre>";print_r ($arr);"</pre>";
//echo $arr['user_1']['1_day']['hourse']."</br>";
//$arr2['a']['b']['c']='abc';
//echo $arr2['a']['b']['c'];
//$user = array();
//$day = array();
$user = array();
foreach($res as $key => $val){
   //$user[$val['id_name'][$val['day'][$val['workplace'][$val['hourse']]]]];
    $user[$val['id_name']][$val['day']]['workplace']= $val['workplace'];
    $user[$val['id_name']][$val['day']]['hourse']= $val['hourse'];
    }
echo "<pre>";print_r($user);echo"</pre>";
echo "count ".count($user);
$keys = array_keys ($user);
print_r($keys);
sort($keys);

print_r($keys);
echo implode(",",$keys);


/*echo "<table>";
for ($i=0;$i<count($user);$i++){
    echo "<tr><td>";
    for ($x=0;$x<31;$x++){
        echo "<td></td>"
    }
}*/

?> 