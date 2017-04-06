<?php

namespace PhoneApp\Tests\Rest;

use PHPUnit\Framework\TestCase;
use PhoneApp\Rest\Phone;

/**
 * @covers Factory
 */
class PhoneTest extends TestCase
{

	   public function testSerchEndPoint(){
          //$rest = new Phone();
          //TODO use a http client to test json responses and http status
          //$rest->search("q=diego");

          $this->assertEquals(true, true);
     }

}
