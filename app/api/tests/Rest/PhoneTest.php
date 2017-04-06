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
     protected $host = "http://localhost/api/";

	   public function testSerchEndPoint(){
          //$rest = new Phone();
          //TODO use a http client to test json responses and http status
          //$rest->search("q=diego");
          $resource = "phone/search?q=diego";
          $response = Request::get($this->host.$resource)->expectsJson()->send();

          $this->assertEquals(true, true);
     }

}
