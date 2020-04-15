<?php

class DbOperation {
    
    private $con;

    function __construct(){
        $db = new db();
        $this->con = $db->conectDB();
    }

    public function createUser($name, $username, $pass){

        if (!$this->isUserExist($username)){
            $password = md5($pass);
            $apiKey = $this->generateApiKey();
            $stmt = $this->con->prepare("INSERT INTO users(name, username, password, api_key) VALUES(:a, :b, :c, :d)");

            $stmt->bindParam(':a', $name);
            $stmt->bindParam(':b', $username);
            $stmt->bindParam(':c', $password);
            $stmt->bindParam(':d', $apiKey);

            $result = $stmt->execute();
            // $stmt->close();
            if ($result) {
                return 0;
            } else {
                return 1;
            }
        } else {
            return 2;
        }
    }

    private function isUserExist($username){
        $stmt = $this->con->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $num_rows = $stmt->rowCount();
        return $num_rows > 0;
    }

    private function generateApiKey(){
        return md5(uniqid(rand(),true));
    }

    public function userLogin($username, $pass){
        $password = md5($pass);
        $stmt = $this->con->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        $num_rows = $stmt->rowCount();
        return $num_rows > 0;
    }

    private function getUser($username){
        $stmt = $this->con->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
}