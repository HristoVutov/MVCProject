<?php
/**
 * Created by PhpStorm.
 * User: Hristo
 * Date: 10/1/2015
 * Time: 19:31
 */

namespace MVCProject\ViewModels;

class HomeViewModel
{
    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
    private $name;

}
