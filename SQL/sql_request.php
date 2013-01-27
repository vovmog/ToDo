<?php
function request($sql, $arr = 'arr', $db = timesheet)
{
    $mysqli = new mysqli("openserver", "root", "", $db);
    $result = $mysqli->query($sql);
    /* check connection */
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }


    /* close connection */
    $mysqli->close();
    // echo "<p>goodby</p>";//
    // if($arr='arr'){
    //    $sql_arr = array();						/////////////////////////////////////////////////////////////////////////
    //    while($row = $result->fetch_assoc()){	/////////////////////          /////////////////////////////////////
    //        $sql_arr[]=$row;
    //   }
    //    return $sql_arr;
    //}
    // else {
    return $result;
//}

}

function res_assoc($res)
{
    $res_arr = array();
    while ($row = $res->fetch_assoc()) { /////////////////////          /////////////////////////////////////
        $res_arr[] = $row;
    }
    return $res_arr;
}

function mysql_getcolumn($result, $makehash = FALSE)
{
    $data = array();
    if (!$makehash) while ($row = $result->fetch_row()) $data[] = $row[0];
    else while ($row = $result->fetch_row()) $data[$row{0}] = $row[1];
    return $data;
}

?>