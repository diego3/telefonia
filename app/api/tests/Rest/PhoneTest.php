<?php

namespace PhoneApp\Tests\Rest;

use PHPUnit\Framework\TestCase;
use PhoneApp\Rest\Phone;
use PhoneApp\Rest\Session;
use Httpful\Request;
use Httpful\Mime;

/**
 * @covers \PhoneApp\Rest\Phone
 */
class PhoneTest extends TestCase
{
     //  http://phphttpclient.com/
     protected $host = "localhost:8542/api/";

     /**
      * @covers \PhoneApp\Rest\Phone::search
      */
     public function testSearchEndPointShouldReturn4PhonesForAdminUser(){
          /*$resource = "phone/search?q=diego";
          $response = Request::get($this->host.$resource)->expectsJson()->send();
          $this->assertFalse($response->hasErrors());
          $phones = $response->body->result;
          $this->assertEquals(4, count($phones));*/
          ob_start();
          $rest = new Phone();
          $rest->search("q=admin");
          $obj = ob_get_contents();
          ob_end_clean(); 
          $response = json_decode($obj);
          
          $this->assertEquals(4, count($response->result), "The admin user should have 4 phones");
     }

     /**
      * @covers \PhoneApp\Rest\Phone::user
      */
     public function testFindUserPhonesShouldReturnEmptyWhenThereIsNoUserLoggedIn(){
          ob_start();
          $phone = new Phone();
          $phone->user();
          $obj = ob_get_contents();
          ob_end_clean();
          $response = json_decode($obj);

          $this->assertTrue(isset($response->auth_error) );
     }

     /**
      * Faz o login e tenta trazer os telefones do usuário logado!
      * 
      * @covers \PhoneApp\Rest\Phone::user
      * @covers \PhoneApp\Rest\Session::login
      */
     public function testFindUserPhonesShouldReturnThePhonesListWhenTheUserIsloggedIn(){
          $_POST["email"] = "admin@admin.com";
          $_POST["password"] = "admin";
          ob_start();
          $session = new Session();
          $session->login();
          $str = ob_get_contents();
          ob_end_clean();
          $login_response = json_decode($str);
          
          $this->assertTrue($login_response->success);
          $this->assertEquals("admin@admin.com", $login_response->email);

          ob_start();
          $phone = new Phone();
          $phone->user();
          $obj = ob_get_contents();
          ob_end_clean();
          $response = json_decode($obj);

          $this->assertEquals(4, count($response->phones));
     }



     /**
      * @covers \PhoneApp\Rest\Phone::user
      * @covers \PhoneApp\Rest\Session::login
      */
     /*public function testFindUserPhonesShouldReturnOk(){
          $email = "admin@admin.com";
          $password = "admin";
          $response = Request::post($this->host."session/login")
                         ->mime(Mime::FORM)
                         ->body("email=".$email."&password=".$password)
                         ->send();
          var_dump($response->body);
          $this->assertTrue(!empty($response->body));

          $resource = "phone/user";
          $response = Request::get($this->host.$resource)->expectsJson()->send();
          
          //$phones = $response->body->phones;
          //var_dump($response->body);
          $this->assertTrue(!empty($response->body->phones), "User phones can't be empty after login success!");
          //unset($_SESSION["userid"]);
     }*/


}
