<?php 
class DBConnection{
    private $servername = "localhost";
    private $username = "root";
    private $password ="";
    private $dbname ="oop_library";

    public $connect;

    public function __construct(){
        try{
            $this->connect = new mysqli($this->servername,$this->username,$this->password,$this->dbname);
            if($this->connect->connect_error){
                throw new Exception ("Error Occur : " .$this->connect->connect_error);
            }
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }
}
?>
