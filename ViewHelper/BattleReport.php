<?php
/**
 * Created by PhpStorm.
 * User: Hristo
 * Date: 10/4/2015
 * Time: 02:29
 */

namespace MVCProject\ViewHelper;


class BattleReport
{

    private $output = '';
    private $attributes = [];
    private $content = '';
    private $options = '';



    public static function create(){ return new self();}



    public function addAttribute($attributeName,$attributeValue){
        $this->attributes[$attributeName] = $attributeValue;

        return $this;
    }

    public function setContent($content){
        foreach($content as $model){
            $this->options .= "<br>You have battle versus ".key($content) . " at " . $model;
        }

        return $this;
    }

    public function render(){

        $output = "<a>";
        $output .= $this->options;
        $output .= "</a>";

        echo $output;
    }



}