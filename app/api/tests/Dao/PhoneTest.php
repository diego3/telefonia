<?php

namespace PhoneApp\Tests\Dao;

use PHPUnit\Framework\TestCase;
use PhoneApp\Factory;
use PhoneApp\Dao\Phone;

/**
 * @covers \PhoneApp\Dao\Phone
 */
class PhoneTest extends TestCase
{
      /**
      * @covers \PhoneApp\Dao\Phone::byId
      */
      public function testById(){
          $phoneId = 6;
          $pdo = Factory::createDbConnection();
          $dao = new Phone($pdo);
          $phone = $dao->byId($phoneId);
          
          $this->assertTrue(!empty($phone));
          $this->assertEquals($phoneId, $phone->getId());
      }
}
