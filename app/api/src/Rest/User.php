<?php
namespace PhoneApp\Rest;

use PhoneApp\DataBase;
use PhoneApp\Model\User as UserModel;
use PhoneApp\Dao\User as UserDao;
use PhoneApp\Factory;

/**
*   Responsável por aceitar requisições http e devolver a resposta apropriada
*   Por default as respostas estão no formato JSON
*/
class User {


    public function insert(){
       //validar e retornar o status e a mensagem de erro
        $name  = $_POST["name"];
        $email = $_POST["email"];
        $pass  = $_POST["password"];

        $dao = Factory::createUserDao();
        $user = new UserModel();

        $user->setName($name)
            ->setEmail($email)
            ->setPassword($pass);

        $success = $dao->insert($user);

        echo json_encode([
            "success" => $success
        ]);
    }

    public function update($id){
      //validar e retornar o status e a mensagem de erro
       parse_str(file_get_contents("php://input"), $_PUT);
       $name  = $_PUT["name"];
       $email = $_PUT["email"];
       $pass  = $_PUT["password"];
       $id    = $_PUT["userid"];

       $dao = Factory::createUserDao();
       $user = new UserModel();

       if(!empty($pass)){
          $user->setPassword($pass);
       }

       $user->setId($id)
            ->setName($name)
            ->setEmail($email);

       $success = $dao->update($user);

       echo json_encode([
           "success" => $success
       ]);
    }

    public function delete($id){
        $dao = Factory::createUserDao();
        $user = new UserModel();
        $user->setId($id);

        $success = $dao->delete($user);

        echo json_encode([
            "success" => $success
        ]);
    }

    public function read($id){
        if(empty($id)){
            echo json_encode([
              "user" => []
            ]);
        }

        $dao = Factory::createUserDao();
        $user = $dao->byId($id, true);

        echo json_encode([
            "user" => $user
        ]);
    }
}
