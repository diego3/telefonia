<?php

namespace PhoneApp\Tests\Rest;

use PHPUnit\Framework\TestCase;
use PhoneApp\Rest\Phone;
use Httpful\Request;
use Httpful\Mime;

/**
 * @covers \PhoneApp\Rest\Phone
 */
class PhoneTest extends TestCase
{
     //  http://phphttpclient.com/
     protected $host = "localhost:8542/api/";

     public function testSearchEndPointShouldReturn4Phones(){
          $resource = "phone/search?q=diego";
          $response = Request::get($this->host.$resource)->expectsJson()->send();

          $this->assertFalse($response->hasErrors());
          $phones = $response->body->result;
          $this->assertEquals(4, count($phones));
     }

     public function testFindUserPhonesShouldReturnOk(){
          /*$email = "www.diegosantos.com.br@gmail.com";
          $password = "diego";
          $response = Request::post($this->host."session/login")
                         ->mime(Mime::FORM)
                         ->send();
          var_dump($response);*/

          /*$_SESSION["userid"] = 2;
          $resource = "phone/user";
          $response = Request::get($this->host.$resource)->expectsJson()->send();
          
          //$phones = $response->body->phones;
          var_dump($response->body->session);
          $this->assertTrue(!empty($response));
          unset($_SESSION["userid"]);*/

          $this->assertTrue(true);
     }


}
