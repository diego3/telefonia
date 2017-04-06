<?php

namespace PhoneApp\Model;

class Phone {
  
    protected $id;
    protected $number;
    protected $user;

    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function getId(){
        return $this->id;
    }

    public function setNumber($num){
        $this->number = $num;
        return $this;
    }

    public function getNumber(){
      return $this->number;
    }

    public function setUser($user){
       $this->user = $user;
       return $this;
    }

    public function getUser(){
      return $this->user;
    }

}
