<?php
/**
 * Created by PhpStorm.
 * User: Hristo
 * Date: 9/29/2015
 * Time: 18:43
 */

namespace MVCProject\Controllers;



abstract class BaseController
{

    public function __contruct()
    {
      $this->onInit();
    }

    protected function onInit(){}
}