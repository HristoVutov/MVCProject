<?php
/**
 * Created by PhpStorm.
 * User: Hristo
 * Date: 9/30/2015
 * Time: 21:20
 */
namespace MVCProject\ViewModels;

class UserRegisterViewModel
{
    private $id;
    private $name;
    private $password;

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }






}