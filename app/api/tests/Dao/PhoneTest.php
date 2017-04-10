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

      /**
      *  @covers \PhoneApp\Dao\Phone::byUserIdAsObject
      */
      public function testByUserIdAsObjectWithAValidUserId(){
          $userid = 3;//admin user
          $pdo = Factory::createDbConnection();
          $dao = new Phone($pdo);
          $phones = $dao->byUserIdAsObject($userid);
          $this->assertTrue(count($phones) > 3, "Admin user should have at least 4 phones");

          $i = 0;
          foreach($phones as $phone){
              if($i == 2){
                break;
              }
              $this->assertTrue(!empty($phone->getId()));
              $this->assertTrue(!empty($phone->getNumber()));
              $i++;
          }
      }
}
