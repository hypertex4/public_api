<?php
class User{

    // database connection and table name
    private $conn;
    private $table_name = "users";

    // object properties
    public $id;
    public $username;
    public $password;
    public $created;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    public function execute_query($query)
    {
        return mysqli_query($this->conn, $query);
    }
    // signup user
    function signup(){

        if($this->isAlreadyExist()){
            return false;
        }
        // query to insert record
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->created=htmlspecialchars(strip_tags($this->created));

        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                username='$this->username', password='$this->password', created='$this->created'";

        // execute query
        if($this->execute_query($query)){
            $this->id = mysqli_insert_id($this->conn);
            return true;
        }
        return false;

    }
    // login user
    function login(){
        // select all query
        $query = "SELECT
                id, username, password, created
            FROM
                " . $this->table_name . " 
            WHERE
                username='".$this->username."' AND password='".$this->password."'";
        // execute query statement
        $stmt = $this->execute_query($query);
        return $stmt;
    }

    // a function to check if username already exists
    function isAlreadyExist(){
        $query = "SELECT *
        FROM
            " . $this->table_name . " 
        WHERE
            username='".$this->username."'";

        // execute query
        $stmt = $this->execute_query($query);
        if(mysqli_num_rows($stmt) > 0){
            return true;
        }
        else{
            return false;
        }
    }
}