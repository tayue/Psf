<?php
/**
 * 演示类
 */

namespace Psf\Bean;


class Functions
{
   public function test(){
       return __CLASS__ . ':' . __FUNCTION__ . "\r\n";
   }
}