
<?php 
// make a class database connection for use 
class Database {
    // define the attritube that is fixed 
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "web_db";
    private $conn;

    // __construct function : special function that gets automatically executed when an object of a class is created. 
    private function __construct(){
        // the connection
        // $this->variable is like object.variable in python 
        // in here $this will be the class name : "Database" 
        // $this->servername : Database servename : localhost   
        $this->conn = new mysqli($this->servername , $this->username , $this->password, $this->dbname);
        // check connection sucess or not 
        if($this->conn->connect_error){
            die("connection failed :".$this->conn->connect_error);
        }
    }
    // fucntion to create and get the connection 
    public static function getConnection(){
        static $instance = null ;
        if($instance === null ){
            $instance = new Database();
        }
        return $instance->conn;
    }
    // function to close connection :
    // if the connection is exist than close it 
    public function closeConnection(){
        if($this->conn !== null ){
            $this->conn->close();
            $this->conn = null ;
        }
    }
}
// how to use :
// 1. go to the file you want to connect with databse 
// 2. apply this file into it : require_once 'db.php'; depends where you import you need to consider use ../ absulote locate 
// 3. create a connection variable : $conn = Database::getConnection();
// 4. check it scuess or not : echo $conn ? "db Connected" : "Failed to connect";
// 5. at the end of the program you can $conn->closeConnection to close the link manually or you can let it closed auto 
?>