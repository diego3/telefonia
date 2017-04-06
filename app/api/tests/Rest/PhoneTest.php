<?php

namespace PhoneApp\Tests\Rest;

use PHPUnit\Framework\TestCase;
use PhoneApp\Rest\Phone;
use Httpful\Request;

/**
 * @covers Factory
 */
class PhoneTest extends TestCase
{
     //http://phphttpclient.com/
     protected $host = "http://localhost:8542/api/";

     public function testSearchEndPointShouldReturn4Phones(){
          $resource = "phone/search?q=diego";
          $response = Request::get($this->host.$resource)->expectsJson()->send();

          $phones = $response->body->result;
          $this->assertEquals(4, count($phones));
     }

}
