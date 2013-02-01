<?php
session_start();
function __autoload($cl_name)
{
    include_once "./classes/" . $cl_name . ".php";
}

if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {

    if (isset($_GET))
        $_GET = stripSlash($_GET);
    if (isset($_POST))
        $_POST = stripSlash($_POST);
    if (isset($_REQUEST))
        $_REQUEST = stripSlash($_REQUEST);
    if (isset($_COOKIE))
        $_COOKIE = stripSlash($_COOKIE);
}

function stripSlash(&$data)
{
    return is_array($data) ? array_map('stripSlashes', $data) : stripslashes($data);
}

$user = new user();

echo $_SESSION['id'];