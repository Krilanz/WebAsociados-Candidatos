<?php
//borra la cookie si el usuario se desloguea
if(isset($_COOKIE['email']) and isset($_COOKIE['password']))
    {
        $email = $_COOKIE['email'];
        $pass = $_COOKIE['password'];
        setcookie('email', $email, time()-1, '/');
        setcookie('password', $pass, time()-1, '/');
    }
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
} else if (isset($_SESSION['user']) != "") {
    header("Location: novedades.php");
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['userId']);
    header("Location: login.php");
    exit;
}
