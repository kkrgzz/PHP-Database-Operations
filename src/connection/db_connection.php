<?php

define("HOST", "localhost");
define("DBNAME", "example");
define("USERNAME", "root");
define("PASSWORD", "");
define("CHARSET", "utf8");

class db_connection{

    public function connect(){
        
        $host       = HOST;
        $dbname     = DBNAME;
        $username   = USERNAME;
        $password   = PASSWORD;
        $charset    = CHARSET;
    
        try {
            $this->db = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $username, $password);
            return $this->db;
        } catch ( PDOException $e ){
            print $e->getMessage();
            return false;
        }
    }

}


?>