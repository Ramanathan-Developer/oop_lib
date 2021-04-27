<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/oop_library/utility/DBConnection.php';

class Book{
    public $connect;

    public function __construct(){
        $db = new DBConnection();
        $this->connect = $db->connect;
    }
    public function saveBook($post){
        $bookName = $_POST['bookName'];
        $bookDesc = $_POST['bookDesc'];
        $authorName = $_POST['authorName'];
        $sql = "INSERT INTO book(bookName,bookDesc,bookAuthor) VALUES ('$bookName','$bookDesc','$authorName')";
        $result = $this->connect->query($sql);
        if($result){
            return json_encode(array('type' => 'Success' , 'message' => 'Book Saved'));
        }else {
            return json_encode(array('type' => 'Failed' , 'message' => 'Book Not Saved'));
        }

    }
    public function getAllBooks(){
        $sql = "SELECT * FROM book";
        $result = $this->connect->query($sql);
        $books = array();
        if($result->num_rows > 0){
            while($rows = $result->fetch_assoc()){
                $books[] = $rows;
            }
            return $books;
        }
    }
    public function editBook($editId){
        $sql = "SELECT * FROM book WHERE bookId = $editId";
        $result = $this->connect->query($sql);
        if($result->num_rows > 0){
            while($rows = $result->fetch_assoc()){
                $data['bookId'] = $rows['bookId'];
                $data['bookName'] = $rows['bookName'];
                $data['bookDesc'] = $rows['bookDesc'];
                $data['authorName'] = $rows['bookAuthor'];
            }
            return json_encode($data);
    }
 }
 public function updateBook($post){
     $bookId = $_POST['bookId'];
     $bookName = $_POST['updateBookName'];
     $bookDesc = $_POST['bookDesc'];
     $authorName = $_POST['authorName'];

     $sql = "UPDATE book SET bookName = '$bookName', bookDesc='$bookDesc', bookAuthor = '$authorName' WHERE bookId= $bookId";
     $result = $this->connect->query($sql);
        if($result){
            return json_encode(array('type' => 'Success' , 'message' => 'Book Update'));
        }else {
            return json_encode(array('type' => 'Failed' , 'message' => 'Book Not Update'));
        }

 }
 public function deleteBook($deleteId){
     $sql = "DELETE FROM book WHERE bookId = $deleteId";
     $execute = $this->connect->query($sql);
     if($execute){
        return json_encode(array('type' => 'Success' , 'message' => 'Book Delete'));
    }else {
        return json_encode(array('type' => 'Failed' , 'message' => 'Book Not Delete'));
    }
 }
}

$book = new Book();
if(isset($_POST['bookName'])){
    //echo "<pre>";
    //print_r($_POST);
    //echo "</pre>";
    $savebook = $book->saveBook($_POST);
    echo $savebook;
}
if (isset($_POST['editId'])){
    $editBook = $book->editBook($_POST['editId']);
    echo $editBook;
}

if(isset($_POST['bookId'])){
    $updateBook = $book->updateBook($_POST);
    echo $updateBook;
}
if(isset($_POST['deleteId'])){
    $deleteBook = $book->deleteBook($_POST['deleteId']);
    echo $deleteBook;
}








?>