<?php
$a = "1";
$b = "1";
//if(isset($a) and isset($b) and ($a===$b)){
//    echo "равны";
//    }else echo "неравны";
if(isset($_COOKIE['cook_name']) and $_COOKIE['cook_name']=="123" or $a = "2"){
echo $_COOKIE['cook_name'];
}
//?>