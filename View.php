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


    public static $data;

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

    /**
     * @return bool
     */
    public static function canUpgrade($waterTo,$foodTo,$water,$food){
        $water = $water-$waterTo;
        $food = $food-$foodTo;
        if($food<0||$water<0){
            return false;
        }

        return true;
    }

}