<?php
class Product{

    // database connection and table name
    private $conn;
    private $table_name = "products";

    // object properties
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    public function execute_query($query)
    {
        return mysqli_query($this->conn, $query);
    }

    // read products
    function read(){

        // select all query
        $query = "SELECT
                c.name as category_name, p.id, p.pname, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            ORDER BY
                p.created DESC";

        // prepare query statement/execute query
//        $stmt = mysqli_query($this->conn,$query);
        $stmt = $this->execute_query($query);

        return $stmt;
    }

    // create product
    function create(){

        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));
        $this->created=htmlspecialchars(strip_tags($this->created));

        // query to insert record
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                pname='$this->name', price='$this->price', description='$this->description', category_id='$this->category_id', created='$this->created'";


        // execute query
        if($stmt = $this->execute_query($query)){
            return true;
        }

        return false;

    }

    // used when filling up the update product form
    function readOne(){

        // query to read single record
        $query = "SELECT
                c.name as category_name, p.id, p.pname, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            WHERE
                p.id = $this->id
            LIMIT
                0,1";

        $stmt = $this->execute_query( $query );

        while ($row = mysqli_fetch_array($stmt)) {
            // set values to object properties
//            $this->id = $row['id'];
            $this->name = $row['pname'];
            $this->price = $row['price'];
            $this->description = $row['description'];
            $this->category_id = $row['category_id'];
            $this->category_name = $row['category_name'];
        }
    }

    // update the product
    function update(){

        // update query
        $query = "UPDATE
                " . $this->table_name . "
            SET
                pname = '$this->name',
                price = '$this->price',
                description = '$this->description',
                category_id = $this->category_id
            WHERE
                id = $this->id ";

        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));
        $this->id=htmlspecialchars(strip_tags($this->id));

        // execute the query
        if($this->execute_query($query)){
            return true;
        }

        return false;
    }

    // delete the product
    function delete(){

        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));

        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = $this->id";

         // execute query
        if($this->execute_query($query)){
            return true;
        }

        return false;

    }

    // search products
    function search($keywords){

        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
        // select all query
        $query = "SELECT
                c.name as category_name, p.id, p.pname, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            WHERE
                p.pname LIKE '$keywords' OR p.description LIKE '$keywords' OR c.name LIKE '$keywords'
            ORDER BY
                p.created DESC";

        // execute query
        $stmt = $this->execute_query($query);

        return $stmt;
    }

    // read products with pagination
    public function readPaging($from_record_num, $records_per_page){

        // select query
        $query = "SELECT
                c.name as category_name, p.id, p.pname, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            ORDER BY p.created DESC
            LIMIT $from_record_num, $records_per_page";

        $stmt = $this->execute_query($query);

        // return values from database
        return $stmt;
    }

// used for paging products
    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name ;

        $stmt = $this->execute_query($query);
        $row = mysqli_fetch_array($stmt);

        return $row['total_rows'];
    }

}