<?php

namespace AppBundle\Service;


class LuckyService
{
  public function generateLuckyNumber(){
      return rand(1,100);
  }

  public function generateLuckyColor(){
    $r = rand(128,255);
      $g = rand(128,255);
      $b = rand(128,255);
      $color = dechex($r) . dechex($g) . dechex($b);
      return "#".$color;
  }

}
