<?php 
// make a class database connection for use 
class Database {
    // define the attribute that is fixed 
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "web_based_assignment";
    private $conn;

    // __construct function : special function that gets automatically executed when an object of a class is created. 
    private function __construct(){
        try {
            // the connection
            // $this->variable is like object.variable in python 
            // in here $this will be the class name : "Database" 
            // $this->servername : Database servername : localhost   
            $dsn = "mysql:host={$this->servername};dbname={$this->dbname};charset=utf8";
            $this->conn = new PDO($dsn, $this->username, $this->password);

            // set PDO attributes 
            // PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ensures that errors are thrown as exceptions
            // PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC makes sure fetched data is returned as an associative array
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage()); // die() function to stop script execution if connection fails
        }
    }

    // function to create and get the connection 
    public static function getConnection(){
        static $instance = null ;
        if($instance === null ){
            $instance = new Database();
        }
        return $instance->conn;
    }

    // function to close connection :
    // if the connection exists then close it 
    public function closeConnection(){
        $this->conn = null; // PDO automatically closes the connection when the object is destroyed
    }
}

// how to use :
// 1. go to the file you want to connect with the database 
// 2. apply this file into it : require_once 'db.php'; depends where you import, you need to consider using ../ absolute path 
// 3. create a connection variable : $conn = Database::getConnection();
// 4. check if it succeeds or not : echo $conn ? "db Connected" : "Failed to connect";
// 5. at the end of the program you can call $conn->closeConnection() to close the link manually or let it close automatically 
?>
