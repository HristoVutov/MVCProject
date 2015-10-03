<?php
/**
 * Created by PhpStorm.
 * User: Hristo
 * Date: 10/1/2015
 * Time: 16:26
 */

namespace MVCProject\Controllers;
use MVCProject\Models\Barracks;
use MVCProject\Models\Nest;
use MVCProject\Models\User;
use MVCProject\View;
use MVCProject\ViewModels\HomeViewModel;
use MVCProject\Models\Map;

class HomeController extends BaseController
{
    public function home(){
        echo "<h1>Home</h1>";

        $us = User::getUserById($_SESSION['id']);
        $us['nests'] = Nest::getUserNests($_SESSION['id']);
        View::$data['user'] = $us;

        $model = new HomeViewModel();
        return new View($model);
    }


    protected function onInit()
    {

    }
}