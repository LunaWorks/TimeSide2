<?php

namespace AppBundle\Service;


class LuckyService
{
  public function generateLuckyNumber(){
      return rand(1,100);
  }
}
