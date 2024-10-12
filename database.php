<?php

// The Database class is designed to handle the connection to a MySQL database.
class Database{
    private $host = 'localhost';
    private $username = 'root';
    private $password = ''; 
    private $dbname = 'adv_guidance';

    protected $connection; // This property will hold the PDO connection object once connected.

    function connect(){
        if($this->connection === null){
            $this->connection = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
        }
        return $this->connection;
    }
}

// Uncomment the lines below to test the connection by creating an instance of the Database class and calling the connect() method.
// $obj = new Database();
// $obj->connect();
