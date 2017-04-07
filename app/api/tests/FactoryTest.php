<?php

namespace PhoneApp\Tests;

use PHPUnit\Framework\TestCase;
use PhoneApp\Factory;
use PhoneApp\Dao\User;
use PhoneApp\Dao\Phone;

/**
 * @covers \PhoneApp\Factory
 */
class FactoryTest extends TestCase
{
    
    public function testCreateDbConnectionMethod(){
        $pdo = Factory::createDbConnection();
        $this->assertInstanceOf(\PDO::class, $pdo);
    }

    /**
     * 
     * @depends testCreateDbConnectionMethod
     */
    public function testCreatePhoneDaoMethod(){
        $dao = Factory::createPhoneDao();
        $this->assertInstanceOf(Phone::class, $dao);
    }

    /**
     * 
     * @depends testCreateDbConnectionMethod
     */
    public function testCreateUserDaoMethod(){
        $dao = Factory::createUserDao();
        $this->assertInstanceOf(User::class, $dao);
    }

}
