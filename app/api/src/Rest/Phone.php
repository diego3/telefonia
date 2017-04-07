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

    /**
     * Traz todos telefones de um determinado usuário
     */
    public function user(){
        if(!isset($_SESSION["userid"])){
            echo json_encode([
               "phones" => [],
               "auth_error" => "Invalid user id"
            ]);
            return;
        }

        $dao = Factory::createPhoneDao();
        $phones = $dao->byUserIdAsArray($_SESSION["userid"]);

        echo json_encode([
            "phones" => $phones
        ]);
    }


    public function insert(){
        $number = isset($_POST["number"]) ? $_POST["number"] : 0;
        $userid = isset($_POST["user"]) ? $_POST["user"] : 0;

        if(empty($number) || empty($userid)){
             echo json_encode([
                "success"    => false,
                "validation" => "The phone number and user id can't be empty both! "
            ]);
            return;
        }

        $dao   = Factory::createPhoneDao();
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
        $id  = isset($_PUT["id"]) ? $_PUT["id"] : 0;
        $new = isset($_PUT["num"]) ? $_PUT["num"] : null;

        if(empty($id) || empty($new)){
            echo json_encode([
                "success" => false,
                "msg" => "validation"
            ]);
            return;
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
            return;
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
              "phone" => [],
              "error" => "Invalid phone id"
            ]);
            return;
        }

        $dao = Factory::createPhoneDao();
        $phone = $dao->byId($id, true);

        echo json_encode([
            "phone" => $phone
        ]);
    }
}
