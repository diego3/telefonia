<?php

namespace PhoneApp;

use PhoneApp\DataBase;
use PhoneApp\Dao\Phone as PhoneDao;
use PhoneApp\Dao\User as UserDao;

class Factory {

    public static function createDbConnection(){
        $db = new DataBase();
        $db->connect(require __DIR__ . "/../database.config.php");
        return $db->getConnection();
    }

    public static function createPhoneDao() {
        $pdo = self::createDbConnection();
        return new PhoneDao($pdo);
    }

    public static function createUserDao() {
        $pdo = self::createDbConnection();
        return new UserDao($pdo);
    }

}
