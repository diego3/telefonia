<?php

namespace PhoneApp\Model;


class User {

  protected $id;
  protected $name;
  protected $phones;
  protected $email;
  protected $password;

  public function setId($id){
      $this->id = $id;
      return $this;
  }

  public function getId(){
      return $this->id;
  }

  public function setName($name){
     $this->name = $name;
     return $this;
  }

  public function getName(){
      return $this->name;
  }

  public function addPhone(Phone $phone){
     $this->phones[] = $phone;
     return $this;
  }

  public function getPhones(){
      return $this->phones;
  }

  public function setPassword($pass){
     $this->password = md5($pass);
     return $this;
  }

  public function getPassword(){
     return $this->password;
  }

  public function setEmail($email){
      $this->email = $email;
      return $this;
  }

  public function getEmail(){
      return $this->email;
  }

}
