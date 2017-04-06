<?php
namespace PhoneApp\Rest;

use PhoneApp\DataBase;
use PhoneApp\Factory;

class Session {

    public function check(){
        $userid = isset($_SESSION["userid"]) ? $_SESSION["userid"] : null;
        echo json_encode(["logged" => isset($_SESSION["user"]), "id" => $userid]);
    }

    public function login(){
        $userEmail = $_POST["email"];
        $userPass  = md5($_POST["password"]);

        $userDao = Factory::createUserDao();
        $user = $userDao->listByUserAndPassword($userEmail, $userPass);

        if(!empty($user)){
            $_SESSION["user"] = true;
            $_SESSION["username"] = $user->getName();
            $_SESSION["useremail"] =  $user->getEmail();
            $_SESSION["userid"] =  $user->getId();

            echo json_encode([
              "success" => true,
              "email" => $user->getEmail()
            ]);
            exit;
        }

        echo json_encode([
            "success"=> false,
            "msg" => "E-mail ou senha incorretos!"
        ]);
    }


    public function logout(){
       if(isset($_SESSION["user"])){
           unset($_SESSION["user"]);
           unset($_SESSION["useremail"]);
           unset($_SESSION["username"]);
           unset($_SESSION["userid"]);
           echo json_encode([
               "success"=> true,
           ]);
           exit;
       }
       echo json_encode([
           "success"=> false,
           "msg" => "There is no session active!"
       ]);
    }
}
