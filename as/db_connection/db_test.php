<?php
// define a class for testing used 

class testDb {
    private $conn; 
    private $servername = "localhost";
    private $username = "root";
    private $password = "";

    // fucntion to make a object of database and connect it auto
    public function __construct($dbName) {
        try {
            $dsn = "mysql:host={$this->servername};dbname={$dbName};charset=utf8";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            // 设置 PDO 错误模式为异常模式
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // 设置数据返回方式为关联数组
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("数据库连接失败: " . $e->getMessage());
        }
    }
    // fucntion to get the connection 
    public function getConnection(){
        return $this->conn;
    }
    // function to close the connection manually 
    public function closeConnection(){
        if($this->conn !== null ){
            $this->conn = null ;
        }
    }
}
// how to use : 
// 1. go to the file you want to connect with databse 
// 2. apply this file into it : require_once 'db_test.php'; depends where you import you need to consider use ../ absulote locate 
// 3. create a database object : $db = new testDb(pass the variable inside: "yourtestdbname")
// 4. use the object function to make connection variable : $db->getConnection()
// 5. check it scuess or not : echo $conn ? "db Connected" : "Failed to connect";
// 6. at the end of the program you can $db->closeConnection(); to close the link manually or you can let it closed auto 
?>