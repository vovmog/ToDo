<?php
/**
 *
 */

class authentication
{

    const SALT = "B_Lock";
    const METHOD = 'aes128';
    const IV = "1234567812345678";
    public $user_id = 0;
    public $user_login = "guest";
    public $user_name = "guest";
    public $role = "guest";
    private $time;
    private $db;
    public $scid;
    public $time_reg;

////////////////////////////////////////////////////////////////////////////////////

    /**
     * Конструктор принимает ssid и scid из кук и сравнивает их с записью в сесcии,
     * если данные есть в сессии то заполняем данные пользователя из данных сессии,
     * если данных в сессии нет то ищем в таблице Auth_users и выбираем от туда id пользователя и
     * дату последнего захода, если дата меньше недели то продолжаем,
     * перезаписываем дату в таблице а также перезаписываем сгенерированный случайный хеш в таблицу,
     * сессию и cookie.
     * @$ssid случайный хеш
     * @$scid хеш на основе USER_AGENT(уникальный);
     *
     */
    function __construct()
    {
        $this->time = time();
        $this->db = new requestDb();
        $this->scid = hash('sha256', serialize($_SERVER['HTTP_USER_AGENT']));
        $ssid = hash('sha256', uniqid(rand(), true) . serialize($_SERVER));

        if (isset($_COOKIE["ssid"]) && isset($_COOKIE["scid"])) { //Проверка кук
            if (isset($_SESSION["ssid"]) && isset($_SESSION["scid"]) && $_COOKIE['ssid'] == $_SESSION['ssid'] && $_COOKIE['scid'] == $_SESSION['scid']) { //если куки есть в сессии и оны равны то берем данные из сессии
                $this->user_id = $_SESSION['id'];
                $this->user_login = $_SESSION['login'];
                $this->role = $_SESSION['role'];
            } else { //Если их в сессии нет то проверяем их в БД и если они есть в БД и время жизни их не закончилось то берем соответственно данные из БД
                $ssid = $this->db->safe($_COOKIE['ssid']);
                $sql = "SELECT id,scid,time FROM Auth_users WHERE ssid = '" . $ssid . "'";
                $res = $this->db->request($sql, "out");
                if ($res) {

                    $this->time_reg  = (int)$res[0]['time'];

                    if ($_COOKIE["scid"] == $res[0]['scid'] && ($this->time - 604800) <= (int)$res[0]['time']) {
                        $_SESSION['id'] = $this->user_id = $res[0]['id'];
                        $sql = "SELECT DISTINCT role,login FROM user WHERE id ='" . $this->user_id . "' ";
                        $n = $this->db->request($sql, "out");
                        $_SESSION['role'] = $this->role = $n[0]['role'];
                        $_SESSION['login'] = $this->user_login = $n[0]['login'];
                        $_SESSION['remember']=1;
                        $_SESSION['scid']=$this->scid;
                        $this->set_ssid(FALSE); //Устанавливаем новую ssid
                    }
                }else{
                    session_destroy();
                    setcookie("ssid","");
                    setcookie("scid","");
                    setcookie("id","");
                }
            }
        } elseif (isset($_POST["login"]) && isset($_POST["password"]) && !empty($_POST["login"]) && !empty($_POST["password"])) { //Авторизация проверка пароля
            $login = $this->db->safe($_POST["login"]);
            $pass = $this->db->safe($_POST["password"]);
            $pass = hash('sha256', hash('sha256', $login . $pass . self::SALT));
            $sql = "SELECT DISTINCT id,psw,role FROM user WHERE login = '" . $login . "'";
            $res = $this->db->request($sql, "out");
            if (($res) and ($pass === $res[0]['psw']))
            {
                $this->user_id = $res[0]['id'];
                $this->role = $res[0]['role'];
                $_SESSION['ssid'] = $ssid;
                $_SESSION['scid'] = $this->scid;
                $_SESSION['id'] = $this->user_id;
                $_SESSION['login'] = $login;
                $_SESSION['role'] = $this->role;
                if(isset($_POST['remember'])){
                    $sql = "DELETE FROM auth_users WHERE scid = '".$this->scid."'"; //защита от случайного дублирования записей
                   $r=$this->db->request($sql);
                    $sql = "INSERT INTO auth_users (id,ssid,scid,time) VALUES ('".$this->user_id."','".$ssid."','".$this->scid."','".$this->time."')";
                    $this->db->request($sql);
                    $_SESSION['remember']=1;
                    setcookie("ssid", $ssid,$this->time+604800);
                    setcookie("scid", $this->scid,$this->time+604800);
                }else{
                    setcookie("ssid", $ssid);
                    setcookie("scid", $this->scid);
                }
                unset($_POST);
                unset($_GET);
                header('Location: ./ ');
            }
        } else {
            if(isset($_POST['login']) or isset($_POST['login'])){
                header('Location: ./ ');
            }
        }

        if(isset($_GET['exit'])){
            if(isset($_SESSION['remember'])){
                $sql = "DELETE FROM auth_users WHERE scid ='".$this->scid."'";
                $res = $this->db->request($sql);
            }

            session_destroy();
            setcookie("ssid","");
            setcookie("scid","");
            setcookie("id","");
            header('location: ./');
        }
    }

////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param bool $new
     * обновление или запись в базу нового ssid
     * а также запись его в сессию и куку с временем жизни неделя.
     */
    private function  set_ssid($new = TRUE)
    {
        $ssid = hash('sha256', uniqid(rand(), true) . serialize($_SERVER));
        if ($new) {
            $scid = $this->scid;
            $sql = "INSERT INTO auth_users (id,time,ssid,scid) VALUES ('" . $this->user_id . "','" . $this->time . "','" . $ssid . "','" . $scid . "') WHERE id";
            $this->db->request($sql);
        } else {
            $sql = "UPDATE auth_users SET ssid = '" . $ssid . "',time = '" . $this->time . "' WHERE scid = '" . $this->scid . "'";
            $r=$this->db->request($sql);
        }
        setcookie('ssid', $ssid, $this->time + 604800);
        $_SESSION['ssid'] = $ssid;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////

    function __destruct()
    {
        unset ($this->db);
    }

////////////////////////////////////////////////////////////////////////////////////////////

    private function code($str)
    {

        return openssl_encrypt($str, self::METHOD, self::SALT, false, self::IV);
    }

    private function decode($str)
    {
        return openssl_decrypt($str, self::METHOD, self::SALT, false, self::IV);
    }

}