<?php
/**
 * Created by PhpStorm.
 * User: Hristo
 * Date: 9/29/2015
 * Time: 17:55
 */

namespace MVCProject;

class View
{
    public static $controllerName;
    public static $actionName;


    public static $viewBag = [];

    public static $html;

    /**
     * @param $model
     */
    public function __construct($model)
    {
        require 'Views'
            .DIRECTORY_SEPARATOR
            .self::$controllerName
            .DIRECTORY_SEPARATOR
            .self::$actionName
            .'.phtml';
    }


}