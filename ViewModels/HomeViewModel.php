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
    private $reports = [];

    /**
     * @return array
     */
    public function getReports()
    {
        return $this->reports;
    }

    /**
     * HomeViewModel constructor.
     * @param array $reports
     */
    public function __construct(array $reports)
    {
        $this->reports = $reports;
    }




}
