<?php

namespace PhoneApp;


class DataBase {

    public $lastError;
    protected $connection;

    public function connect(array $options){
        $dsn = 'mysql:host='.$options["host"].';dbname='.$options["database"];

        try {
            $conn = new \PDO($dsn, $options["user"], $options["password"]);
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $this->connection = $conn;
            return true;
        } catch (\PDOException $e) {
            $this->lastError = $e->getMessage();
            return false;
        }
    }

    public function getConnection(){
       return $this->connection;
    }



}
