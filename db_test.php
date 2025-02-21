<?php
// define a class for testing used 

class testDb {
    private $conn; 
    // fucntion to make a object of database and connect it auto
    public function __construct($host , $user ,$password , $dbName){
        $this->conn = new mysqli($host , $user , $password , $dbName);
        if($this->conn->connect_error){
            die("connection failed".$this->conn->connect_error);
        }
    }
    // fucntion to get the connection 
    public function getConnection(){
        return $this->conn;
    }
    // function to close the connection manually 
    public function closeConnection(){
        if($this->conn !== null ){
            $this->conn->close();
            $this->conn = null ;
        }
    }
}
// 1. go to the file you want to connect with databse 
// 2. apply this file into it : require_once 'db_test.php'; depends where you import you need to consider use ../ absulote locate 
// 3. create a database object : $db = new Database(pass the variable inside: "localhost","root","","yourtestdbname")
// 4. use the object function to make connection variable : $db->getConnection()
// 5. check it scuess or not : echo $conn ? "db Connected" : "Failed to connect";
// 6. at the end of the program you can $conn->closeConnection to close the link manually or you can let it closed auto 
?>