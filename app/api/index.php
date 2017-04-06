<?php
session_start();

//use PhoneApp\Model\User;
//$loader = require __DIR__ . "/../../vendor/autoload.php";
//$loader->add('PhoneApp', __DIR__."/../../vendor/app");
//require_once __DIR__."/../../vendor/app/Model/User.php";
//$user = new \PhoneApp\Model\User;

require __DIR__."/src/DataBase.php";
require __DIR__."/src/Dao/User.php";
require __DIR__."/src/Dao/Phone.php";
require __DIR__."/src/Model/User.php";
require __DIR__."/src/Model/Phone.php";
require __DIR__."/src/Factory.php";

//ponto de entrada das requisições
$uri    = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

if(empty($uri) || strpos($uri, "api") === false){
     http_response_code(404, "Invalid API access");
     exit;
}

$parts = explode("/", $uri);
$id = null;

if(count($parts) == 3){
    require __DIR__."/src/Rest/".ucfirst($parts[2]).".php";
    $resource = "PhoneApp\\Rest\\". ucfirst($parts[2]);
}
else if(count($parts) == 4){
    require __DIR__."/src/Rest/".ucfirst($parts[2]).".php";
    $resource = "PhoneApp\\Rest\\". ucfirst($parts[2]);
    $id = $parts[3];
}

$rest = new $resource;

if(!empty($id) && !is_numeric($id)){
     if(strpos($id, "?") !== false){
         $pts = explode("?", $id);
         $id = $pts[0];
         $rest->$id($pts[1]);
         exit;
     }

     $rest->$id();
     exit;
}

switch ($method) {
  case 'POST':
      $rest->insert();
      break;
  case 'GET':
      $rest->list($id);
      break;
  case 'PUT':
      $rest->update($id);
      break;
  case 'DELETE':
      $rest->delete($id);
      break;
  default:
    echo json_encode([
        "error" => "invalid method"
    ]);
    break;
}
