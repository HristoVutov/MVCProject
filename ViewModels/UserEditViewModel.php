<?php
/**
 * Created by PhpStorm.
 * User: Hristo
 * Date: 9/29/2015
 * Time: 18:01
 */

namespace MVCProject\ViewModels;

class UserEditViewModel
{
    private $id;
    private $name;

    /**
     * UserEditViewModel constructor.
     * @param $id
     * @param $name
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

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


}
