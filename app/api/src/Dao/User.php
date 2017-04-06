<?php

namespace PhoneApp\Dao;

use PhoneApp\Model\User as UserModel;
use PhoneApp\DataBase;

class User {

  protected $conn;

  public function __construct(\PDO $dataBaseConnection){
      $this->conn = $dataBaseConnection;
  }

  public function insert(UserModel $user){
      $this->conn->beginTransaction();

      try {
          $stmt = $this->conn->prepare(
              'INSERT INTO user (email, username, password) VALUES (:email, :name, :password)'
          );

          $stmt->bindValue(':email', $user->getEmail());
          $stmt->bindValue(':name', $user->getName());
          $stmt->bindValue(':password', $user->getPassword());
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

  public function update(UserModel $user){
      $this->conn->beginTransaction();
      try {
          $sql = "update user set email = :email,  username = :name ";

          if(!empty($user->getPassword())){
            $sql .= " ,  password = :password ";
          }

          $sql .= " where userid = :id ";
          $stmt = $this->conn->prepare($sql);

          $stmt->bindValue(':email', $user->getEmail());
          $stmt->bindValue(':name', $user->getName());

          if(!empty($user->getPassword())){
              $stmt->bindValue(':password', $user->getPassword());
          }

          $stmt->bindValue(':id', (int)$user->getId());
          $stmt->execute();
          $this->conn->commit();
          return true;
      }
      catch(\PDOException $e) {
          //log the error ?
          $this->conn->rollback();
          return false;
      }
  }

  public function delete($user){
      $this->conn->beginTransaction();
      try {
          $stmt = $this->conn->prepare(
              'delete from user where userid = :id'
          );
          $stmt->bindValue(':id', $user->getId());
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
      $statement = $this->conn->prepare("select * from user");
      $statement->execute();
      $results = [];

      while($row = $statement->fetch(\PDO::FETCH_OBJ)) {
            $user = new UserModel();

            $user->setId($row->userid);
            $user->setName($row->username);
            $user->setEmail($row->email);

            $results[] = $user;
      }
      return $results;
  }

  public function byId($id, $array = false){
      try{
          $statement = $this->conn->prepare("select * from user where userid = :id");
          $statement->bindValue(":id", $id);

          $statement->execute();
          $row = $statement->fetch(\PDO::FETCH_OBJ);
          if(empty($row)){
            return null;
          }

          if($array){
            $row->password = null;
            return $row;
          }

          $user = new UserModel();
          $user->setId($row->userid);
          $user->setName($row->username);
          $user->setEmail($row->email);
          $user->setPassword($row->password);
          return $user;
      }catch(\PDOException $e) {
          //log the error ?
          return $e->getMessage();
      }
  }

  public function listByUserAndPassword($userEmail, $userPass){
        $statement = $this->conn->prepare("select * from user where email = :email and password = :password");
        $statement->bindValue(":email", $userEmail);
        $statement->bindValue(":password", $userPass);
        $statement->execute();

        $row = $statement->fetch(\PDO::FETCH_OBJ);
        if(empty($row)){
          return null;
        }

        $user = new UserModel();
        $user->setId($row->userid);
        $user->setName($row->username);
        $user->setEmail($row->email);
        $user->setPassword($row->password);
        return $user;
  }

}
