<?php
require_once('./SQL/sql_request.php');
require_once('func.php');
$tmp = array();
$tmp['one']['two']['three']= 123;
$tmp['one']['two_two']=321;
echo "<pre>";print_r ($tmp);echo"</pre>";
$sql = "SELECT id_name,name.name,day,workplace.name AS workplace_name,hourse,timesheet.comment
        FROM name,timesheet,workplace
        WHERE name.id = timesheet.id_name AND timesheet.workplace = workplace.id AND month ='January' AND year='2013'";
$result = request($sql);
$res = res_assoc($result);
echo $sql."</br>";
echo "<pre>";print_r ($res);echo"</pre>";

$user = array();
foreach($res as $key => $val){
    $user[$val['name']]['user_id']= $val['id_name'];
    $user[$val['name']][$val['day']]['workplace']= $val['workplace_name'];
    $user[$val['name']][$val['day']]['hourse']= $val['hourse'];
    $user[$val['name']][$val['day']]['comment']= $val['comment'];
    $user[$val['name']][$val['day']]['id_name']= $val['id_name'];
    }
$key = array_search('1',$user);
echo $key."</br><hr>";
echo "<pre>";var_dump($user);echo"</pre>";
echo "<pre>";print_r($user);echo"</pre>";
echo "count ".count($user);
$keys = array_keys ($user);
print_r($keys);
sort($keys);

print_r($keys);
$str_name =implode(",",$keys);
echo $str_name;
echo "</br></br>".$user[0]['4']['hourse'];

echo "<table>";
foreach($user as $name => $day){
    echo "<tr><td>".$name."</td>";
    for ($i=1;$i<=31;$i++){
    echo "<td>h=".$user[$name][$i]['hourse']." <td>";
    }
    echo "<tr>";

}

