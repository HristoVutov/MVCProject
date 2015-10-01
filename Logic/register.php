<?php
/**
 * Created by PhpStorm.
 * User: Hristo
 * Date: 10/1/2015
 * Time: 13:30
 */


require_once 'index.php';

if (isset($_POST['username'], $_POST['password'])) {
    try {
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $app->register($user, $pass);

        if ($app->login($user, $pass)) {
            header("Location: profile.php");
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}


loadView("Users","register");