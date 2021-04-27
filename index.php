<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/oop_library/classes/book.php';
$db = new DBConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management Using Oop Learning</title>
    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!--Boostrap Script-->
    <script  src="js/bootstrap.min.js"></script>
    <!--JQuery CDN-->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b>Library Management System</b>
                        <button class="btn btn-success btn-md float-right"  data-toggle="modal" data-target="#addBook">Add Book</button>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="15%">Books No</th>
                                    <th width="55%">Books Name</th>
                                    <th width="30%"> Manage Books</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $bookObj = new Book();
                                $books = $bookObj->getAllBooks();
                                $no = 0;
                                foreach($books as $book) :
                                    $no++;
                            
                            ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td>
                                        
                                            <h4><?php echo $book['bookName'];?></h4>
                                            <small>--By <?php echo $book['bookAuthor']; ?>  </small>
                                        </td>
                                        <td>
                                            <button class="btn btn-warning btn-sm editBookBtn1" id="<?php echo $book['bookId']; ?>">Edit</button>
                                            <button class="btn btn-danger btn-sm deleteButton" id="<?php echo $book['bookId']; ?>">Delete</button>
                                        </td>
                                    </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Add book Modal -->
<div class="modal fade" id="addBook" tabindex="-1" role="dialog" aria-labelledby="formLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formLabel">Add Book Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="addBookForm">
                <div class="form-group">
                    <label for="bookName">Book Name</label>
                    <input type="text" name="bookName" class="form-control" required placeholder="Enter the Book name">
                </div>
                <div class="form-group">
                    <label for="bookDesc">Book Description</label>
                    <input type="text" name="bookDesc" class="form-control" required placeholder="Enter the Book Description">
                </div>
                <form id="addBookForm">
                <div class="form-group">
                    <label for="authorName">Author Name</label>
                    <input type="text" name="authorName" class="form-control" required placeholder="Enter the Author name">
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="addBookBtn">Add Book</button>
      </div>
    </div>
  </div>
</div>
<!--Edit Book--->
<div class="modal fade" id="editBookModal" tabindex="-1" role="dialog" aria-labelledby="formLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formLabel">Edit Book</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="editBookForm">
                <div class="form-group">
                    <label for="bookName">Book Name</label>
                    <input type="text" name="updateBookName" id="editBookName" class="form-control" required placeholder="Enter the Book name">
                    <input type="hidden" name="bookId" id="bookId">
                </div>
                <div class="form-group">
                    <label for="bookDesc">Book Description</label>
                    <input type="text" name="bookDesc" id="bookDesc"class="form-control" required placeholder="Enter the Book Description">
                </div>
                <form id="addBookForm">
                <div class="form-group">
                    <label for="authorName">Author Name</label>
                    <input type="text" name="authorName" id="authorName" class="form-control" required placeholder="Enter the Author name">
                </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="updateBook" name="updateBtn">Update Book</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Alert-->
<div class="modal fade" id="alert" tabindex="-1" role="dialog" aria-labelledby="formLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formLabel">Alert</h5>
      </div>
      <div class="modal-body">
        <div class="alert">

        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
//add
$(document).ready(function(){
    $('#addBookBtn').on('click', function(){
        $.post('classes/book.php', $('form#addBookForm').serialize(), function (data){
            var data = JSON.parse(data);
            if(data.type == 'Success'){
                $('#addBook').modal('hide');
                $('#alert').modal('show');
                $('#alert .alert').addClass('alert-success').append(data.message).delay(15000).fadeOut('slow',function(){
                    location.reload();
                });
            }else{
                $('#addBook').modal('hide');
                $('#alert').modal('show');
                $('#alert .alert').addClass('alert-danger').append(data.message).delay(15000).fadeOut('slow',function(){
                    location.reload();
                });
            }
        });
    });
    $('.editBookBtn1').on('click', function(e){
      $('#editBookModal').modal('show');
        $.post('classes/book.php', {editId : e.target.id} , function (data){
            var data = JSON.parse(data);
             $('#editBookName').val(data.bookName);
             $('#bookDesc').val(data.bookDesc);
             $('#authorName').val(data.authorName);
             $('#bookId').val(data.bookId);
        });
    });
//edit
    $('#updateBook').on('click', function(){
        $.post('classes/book.php', $('form#editBookForm').serialize(), function (data){
            var data = JSON.parse(data);
            if(data.type == 'Success'){
                $('#editBookModal').modal('hide');
                $('#alert').modal('show');
                $('#alert .alert').addClass('alert-success').append(data.message).delay(15000).fadeOut('slow',function(){
                    location.reload();
                });
            }else{
                $('#editBookModal').modal('hide');
                $('#alert').modal('show');
                $('#alert .alert').addClass('alert-danger').append(data.message).delay(15000).fadeOut('slow',function(){
                    location.reload();
                });
            }
        });
    });
//delete
  $('.deleteButton').on('click' , function(e){
      $.post('classes/book.php', {deleteId : e.target.id}, function(data){        
        var deleteConfirm = confirm('Are you sure want to Delete the Book');
        if(deleteConfirm){
          var data = JSON.parse(data);
          if(data.type == 'Success'){
                $('#alert').modal('show');
                $('#alert .alert').addClass('alert-success').append(data.message).delay(15000).fadeOut('slow',function(){
                    location.reload();
                });
            }else{
                $('#alert').modal('show');
                $('#alert .alert').addClass('alert-danger').append(data.message).delay(15000).fadeOut('slow',function(){
                    location.reload();
                });
            }
        }else{
          return false;
        }

      });
  });
});
</script>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>