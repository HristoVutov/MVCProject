<?php
/**
 * Created by PhpStorm.
 * User: Hristo
 * Date: 10/2/2015
 * Time: 20:57
 */

namespace MVCProject\ViewModels;


class MapProfileViewModel
{
    private $x;
    private $y;
    private $ants = [];

    /**
     * ProfileViewModel constructor.
     * @param $x
     * @param $y
     */
    public function __construct($x, $y,$ants = [])
    {
        $this->x = $x;
        $this->y = $y;
        $this->ants = $ants;
    }

    /**
     * @return mixed
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return mixed
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @return array
     */
    public function getAnts()
    {
        return $this->ants;
    }

}