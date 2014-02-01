<?php
require_once("./init.php");
/*$iv = "1234567812345678";
$string = generatePassword(8)."<br>".$_SERVER['HTTP_USER_AGENT']."<br>".$_SERVER['REMOTE_ADDR'];
$pass = '1234';
$method = 'aes128';
$a= openssl_encrypt ($string, $method, $pass, false, $iv);
 echo $a."<br>";
$b = openssl_decrypt($a, 'aes128', $pass, false, $iv);
echo $b."<br>";

//Генератор случайной строки по умолчанию 8 символов
function generatePassword($length = 8){
    $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
    $numChars = strlen($chars);
    $string = '';
    for ($i = 1; $i < $length; $i++) {
        $string .= substr($chars, mt_rand(1, $numChars) - 1, 1);
    }
    return $string;
}

echo "Пароль из 8 символов: " . generatePassword(8) . "n";*/
//$b = oppen openssl_decrypt($pass,$a);

//echo hash('sha256', uniqid(rand(), true).serialize($_SERVER));
//echo "<br>".hash('sha256',serialize($_SERVER["HTTP_USER_AGENT"]));
//echo "<br>".time();

/*$db=new requestDb();
$ssid=$db->safe($_COOKIE['ssid']);
$scid=$db->safe($_COOKIE['scid']);
$sql = "SELECT DISTINCT id,scid FROM Auth_users WHERE ssid = '12121'";
$res= $db->request($sql,"out");
print_r($res);
$time = time()-604800;
echo time()." ".$time;*/
/*$login = 'vovmog';
$pass = "258654";
$salt = "B_Lock";
$pass1 = hash('sha256',$login.$pass.$salt);
$pass2 = hash('sha256',(hash('sha256',$login.$pass.$salt)));
var_dump($pass1);
echo "<br>";
var_dump($pass2);
echo "<br>".time();
*/

$DB = new requestDb();
$sql = "SELECT id,scid,time FROM Auth_users";
$res = $DB->request($sql,"out");
var_dump($res);

