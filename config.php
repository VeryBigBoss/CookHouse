<?php
/**
 * Created by PhpStorm.
 * User: Антон
 * Date: 13.01.2018
 * Time: 18:54
 */


function getLogin()
{
    $login = "";
    $fp = fopen('cfg.txt', 'r');
    if ($fp) {
        while (!feof($fp)) {
            $mytext = fgets($fp);
            $login = strstr($mytext, 'login:');
            if ($login != "") {
                $login = trim(str_replace('login:', '', $login));
                return $login;
            }
        }
    } else echo "Ошибка при открытии файла";
    fclose($fp);
    return "";
}

function getPassword()
{
    $password = "";
    $fp = fopen('cfg.txt', 'r');
    if ($fp) {
        while (!feof($fp)) {
            $mytext = fgets($fp);
            $password = strstr($mytext, 'password:');
            if ($password != "") {
                $password = trim(str_replace('password:', '', $password));
                return $password;
            }
        }
    } else echo "Ошибка при открытии файла";
    fclose($fp);
    return "";
}

function getBrowserInfo()
{
    $user_agent = $_SERVER["HTTP_USER_AGENT"];
    if (strpos($user_agent, "Firefox") !== false) $browser = "Firefox";
    elseif (strpos($user_agent, "Opera") !== false) $browser = "Opera";
    elseif (strpos($user_agent, "Chrome") !== false) $browser = "Chrome";
    elseif (strpos($user_agent, "MSIE") !== false) $browser = "Internet Explorer";
    elseif (strpos($user_agent, "Safari") !== false) $browser = "Safari";
    else $browser = "Неизвестный";
    if (strpos($user_agent, "MSIE") !== false)
    {
        echo "Пожалуйста, зайдите через другой более современный браузер, т.к. Ваш браузер: $browser - унылое давно";
        exit();
    }
}

?>