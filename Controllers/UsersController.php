<?php
/**
 * Created by PhpStorm.
 * User: Hristo
 * Date: 9/28/2015
 * Time: 18:05
 */
namespace MVCProject\Controllers;

use MVCProject\Models\Map;
use MVCProject\View;
use MVCProject\ViewModels\UserEditViewModel;
use MVCProject\ViewModels\UserRegisterViewModel;
use MVCProject\Models\User;

class UsersController extends BaseController
{



    public function edit($id, $name)
    {
        $res = User::getAll();
        while ($row = $res->fetch_assoc()) {
            var_dump($row);
        }


        $model = new UserEditViewModel($id,$name);
        return new View($model);
    }

    public function register(){
        if (isset($_POST['username'], $_POST['password'])) {
            try {
                htmlspecialchars($user = $_POST['username']);
                htmlspecialchars($pass = $_POST['password']);
                if(!empty($user)&&!empty($pass)) {
                    if (User::isRegistered($user)) {
                        throw new \Exception('Username already exists');
                    } else {
                       if(User::tryReg($user, $pass)){
                           $_SESSION['id'] = User::getUser($user)[0];
                           for($i = 0;$i<2;$i++){Map::assignMap();}
                           session_destroy();
                           header("Location: /MVCProject/home/home");
                           exit;
                       }else{
                           throw new \Exception('Error occured during registration');
                       }
                    }
                }else{
                    throw new \Exception('All fields required');
                }


            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        $model = new UserRegisterViewModel();
        return new View($model);
    }

    public function login(){
        if (isset($_POST['username'], $_POST['password'])) {
            try {
                htmlspecialchars($user = $_POST['username']);
                htmlspecialchars($pass = $_POST['password']);
                if(User::tryLog($user,$pass)){
                    $_SESSION['id'] = User::getUser($user)[0];
                    $nests = Nest::getUserNests($_SESSION['id']);
                    if(empty($_SESSION['nestid'])){
                        $_SESSION['nestid'] = $nests[0];
                    }
                    header("Location: /MVCProject/home/home");
                    exit;

                }
                else{
                    throw new \Exception('Wrong Username or Password');
                }

            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        $model = new UserRegisterViewModel();
        return new View($model);
    }

    public function logout(){
        session_destroy();
        header("Location: /MVCProject/home/home");

    }
}