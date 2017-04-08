<?php

namespace PhoneApp\Dao;

use PhoneApp\Model\Phone as PhoneModel;
use PhoneApp\DataBase;

class Phone {

  public $conn;

  public function __construct(\PDO $dataBaseConnection){
      $this->conn = $dataBaseConnection;
  }

  public function insert(PhoneModel $phone){
      $this->conn->beginTransaction();

      try {
          $stmt = $this->conn->prepare(
              'INSERT INTO phones (phonenum, userid) VALUES (:number, :userid)'
          );

          $stmt->bindValue(':number', $phone->getNumber());
          $stmt->bindValue(':userid', $phone->getUser());
          $stmt->execute();
          $lastid = $this->conn->lastInsertId();
          $this->conn->commit();
          return $lastid;
      }
      catch(\Exception $e) {
          //log the error ?
          $this->conn->rollback();
          return false;
      }
  }

  public function update(PhoneModel $phone){
      $this->conn->beginTransaction();
      try {
          $sql = 'update phones set phonenum = :number where telefoneid = :id';
          $stmt = $this->conn->prepare($sql);

          $stmt->bindValue(':number', $phone->getNumber());
          $stmt->bindValue(':id', $phone->getId());
          $stmt->execute();

          $this->conn->commit();
          return true;
      }
      catch(\Exception $e) {
          //log the error ?
          $this->conn->rollback();
          return false;
      }
  }

  public function delete($phone){
      $this->conn->beginTransaction();
      try {
          $stmt = $this->conn->prepare(
              'delete from phones where telefoneid = :id'
          );
          $stmt->bindValue(':id', $phone->getId());
          $stmt->execute();
          $this->conn->commit();
          return true;
      }catch(\Exception $e) {
          //log the error ?
          $this->conn->rollback();
          return false;
      }
  }


  public function listAll(){
      $statement = $this->conn->prepare("select * from phones");
      $statement->execute();
      $results = [];

      while($row = $statement->fetch(\PDO::FETCH_OBJ)) {
            $phone = new PhoneModel();
            $phone->setId($row->telefoneid);
            $phone->setNumber($row->phonenum);
            $phone->setUser($row->userid);
            $results[] = $phone;
      }
      return $results;
  }

  public function byUserIdAsObject($userid){
      $statement = $this->conn->prepare("select * from phones where userid = :id");
      $statement->bindValue(":id", $userid);
      $statement->execute();
      $results = [];

      while($row = $statement->fetch(\PDO::FETCH_OBJ)) {
            $phone = new PhoneModel();
            $phone->setId($row->telefoneid);
            $phone->setNumber($row->phonenum);
            $phone->setUser($row->userid);
            $results[] = $phone;
      }
      return $results;
  }

  public function byUserIdAsArray($userid){
      $statement = $this->conn->prepare("select * from phones where userid = :id");
      $statement->bindValue(":id", $userid);
      $statement->execute();
      $results = [];

      while($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $results[] = $row;
      }

      return $results;
  }

  public function byTextAsArray($text){
      $q = strtolower($text);
      $sql = "select p.phonenum, u.userid, u.username, u.email from user as u
              join phones as p on p.userid = u.userid
              where lower(u.username) like :text or p.phonenum like :text2 " ;
      $statement = $this->conn->prepare($sql);
      $statement->bindValue(":text", '%'.$q.'%');
      $statement->bindValue(":text2", '%'.$q.'%');
      $statement->execute();
      $results = [];

      while($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $results[] = $row;
      }
      return $results;
  }

  public function byId($phoneid){
      try{
          $statement = $this->conn->prepare("select * from phones where telefoneid = :id");
          $statement->bindValue(":id", $phoneid);
          $statement->execute();

          $row = $statement->fetch(\PDO::FETCH_OBJ);
          if(empty($row)){
              return null;
          }
      }catch(\PDOException $e){
          //$e->getMessage();
          return null;
      }

      $phone = new PhoneModel();
      $phone->setId($row->telefoneid);
      $phone->setNumber($row->phonenum);
      $phone->setUser($row->userid);
      return $phone;
  }

}
