<?php
class Database
{

    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "api_db";
    private $username = "root";
    private $password = "";
    public $conn;


    // get the database connection
    public function getConnection()
    {

        $this->conn = null;

        try {
            $this->conn= mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
        } catch (Exception $e) {
            echo "Connection error: " . $e->getMessage();
        }

        return $this->conn;
    }


}
?>