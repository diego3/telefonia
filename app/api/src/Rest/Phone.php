<?php
namespace PhoneApp\Rest;

use PhoneApp\DataBase;
use PhoneApp\Model\Phone as PhoneModel;
use PhoneApp\Dao\Phone as PhoneDao;
use PhoneApp\Factory;

/**
*   Responsável por aceitar requisições http e devolver a resposta apropriada
*   Por default as respostas estão no formato JSON
*/
class Phone {

    public function search($params){
        list($q, $term) = explode("=", $params);

        $dao = Factory::createPhoneDao();
        $phones = $dao->byTextAsArray($term);

        echo json_encode([
            "result" => $phones
        ]);
    }

    public function user(){
        $id = $_SESSION["userid"];

        if(empty($id)){
            echo json_encode([
              "phones" => []
            ]);
        }

        $dao = Factory::createPhoneDao();
        $phones = $dao->byUserIdAsArray($id);

        echo json_encode([
            "phones" => $phones
        ]);
    }


    public function insert(){
       //validar retornando o status e a mensagem de erro
        $number = $_POST["number"];
        $userid = $_POST["user"];

        if(empty($number)){

        }
        if(empty($userid)){

        }

        $dao = Factory::createPhoneDao();
        $phone = new PhoneModel();

        $phone->setNumber($number)->setUser($userid);
        $lastid = $dao->insert($phone);

        echo json_encode([
            "success" => !empty($lastid),
            "last_id" => $lastid
        ]);
    }

    public function update($id){
        parse_str(file_get_contents("php://input"), $_PUT);
        $id  = $_PUT["id"];
        $new = $_PUT["num"];

        if(empty($id) || empty($new)){
            echo json_encode([
                "success" => false,
                "msg" => "validation"
            ]);
            exit;
        }

         $dao = Factory::createPhoneDao();
         $phone = new PhoneModel();

         $phone->setNumber($new);
         $phone->setId($id);

         $success = $dao->update($phone);

         echo json_encode([
             "success" => $success
         ]);
    }

    public function delete($id){
        if(empty($id)){
            echo json_encode([
                "success" => false,
                "msg" => "id cant be empty"
            ]);
            exit;
        }

        $dao = Factory::createPhoneDao();
        $phone = new PhoneModel();

        $phone->setId($id);

        $success = $dao->delete($phone);

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

        $dao = Factory::createPhoneDao();
        $user = $dao->byId($id, true);

        echo json_encode([
            "user" => $user
        ]);
    }
}
