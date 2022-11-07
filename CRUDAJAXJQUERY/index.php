
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Group 8 CRUD AJAX</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/><!--Font awesome for icons-->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.22/datatables.min.css"/>  <!--datatables is a jquery plugin or style sheet that gives us the use of a search function along with limiting data entries-->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
</head>
<body>
 
<div class="container">
  <div class="row">
    <div class="col-lg-6">
        <br>
      <h4>Student Records</h4>  
    </div>
    <div class="col-lg-6">
      <button type="button" class="btn btn-primary m-1 float-right" data-toggle="modal" data-target="#addModal">
      <i class="fa fa-plus"></i> Add New Student</button>
    </div>
  </div><br>
</div>
<div class="container">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="table-responsive" id="tableData">
        <h3 class="text-center text-success" style="margin-top: 150px;">Loading...</h3>
      </div>
    </div>
  </div>
</div>
<!-- Add Record  Modal -->
<div class="modal" id="addModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add New Student</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <form id="formData">
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" placeholder="Enter Name" required="">
          </div>
          <div class="form-group">
            <label for="email">Age:</label>
            <input type="number" class="form-control" name="Age" placeholder="Enter Age" required="">
          </div>
          <div class="form-group">
            <label for="username">Course:</label>
            <input type="text" class="form-control" name="course" placeholder="Enter Course" required="">
          </div>
        
          <hr>
          <div class="form-group float-right">
            <button type="submit" class="btn btn-success" id="submit">Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>  
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Edit Record  Modal -->
<div class="modal" id="editModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Student</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <form id="EditformData">
          <input type="hidden" name="id" id="edit-form-id">
          <div class="form-group">
             <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" required="">
          </div>
          <div class="form-group">
            <label for="email">Age:</label>
            <input type="number" class="form-control" name="Age" id="Age" placeholder="Enter Age" required="">
          </div>
          <div class="form-group">
            <label for="username">Course:</label>
            <input type="text" class="form-control" name="course" id="course" placeholder="Enter Course" required="">
          </div>
          <hr>
          <div class="form-group float-right">
            <button type="submit" class="btn btn-primary" id="update">Update</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>  
        </form>
      </div>
    </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.22/datatables.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript">
      $(document).ready(function(){
      showAllName();
      //View Record
      function showAllName(){
        $.ajax({
          url : "config/dbsend.php",       
          type: "POST",
          data : {action:"view"},
          success:function(response){
              $("#tableData").html(response);       //shows all Student in table at the foodadd php file and passes it to a div class named table
              $("table").DataTable({
                order:[0, 'DESC']
              });
            }
          });
        }
        //insert ajax request data
        $("#submit").click(function(e){
            if ($("#formData")[0].checkValidity()) { //if submit is clicked the form is checked and is then redirected to a url in form data that allows it to pass the 
              e.preventDefault();                       //values to a sql query and then hides the modal automatically
              $.ajax({
                url : "config/dbsend.php",
                type : "POST",
                data : $("#formData").serialize()+"&action=insert",
                success:function(response){
                  Swal.fire({
                    icon: 'success',
                    title: 'Customer added successfully',
                  });
                  $("#addModal").modal('hide');
                  $("#formData")[0].reset();
                  showAllName();//reloads the table
                }
              });
            }
        });
        //Edit Record
        $("body").on("click", ".editBtn", function(e){
          e.preventDefault();
          var editId = $(this).attr('id');
          $.ajax({
            url : "config/dbsend.php",
            type : "POST",
            data : {editId:editId},
            success:function(response){
              var data = JSON.parse(response);
              $("#edit-form-id").val(data.id);       //edit record takes the json to autofill the update modal
              $("#name").val(data.Namename);
              $("#Age").val(data.NameAge);
              $("#course").val(data.Course);
             console.log(response);
            }

          });
           $("#update").click(function(e){
      if ($("#EditformData")[0].checkValidity()) {
        e.preventDefault();
        $.ajax({
          url : "config/dbsend.php",
          type : "POST",
          data : $("#EditformData").serialize()+"&action=update", //uses the record to get the id to call the update route in foodadd to get the sql function
          success:function(response){
            console.log(response);
            Swal.fire({
              icon: 'success',
              title: 'Customer updated successfully',
            });
            $("#editModal").modal('hide');
            $("#EditformData")[0].reset();
            showAllName();

          }
        });
      }
    });

        });




    $("body").on("click", ".deleteBtn", function(e){
      e.preventDefault();
      var tr = $(this).closest('tr');
      var deleteBtn = $(this).attr('id');
      if (confirm('Are you sure want to delete this Record')) { //gets the id to place the delete action to the delete function
        $.ajax({
          url : "config/dbsend.php",
          type : "POST",
          data : {deleteBtn:deleteBtn},
          success:function(response){
            tr.css('background-color','#ff6565');
            Swal.fire({
              icon: 'success',
              title: 'Customer delete successfully',
            });
            showAllName();
          }
        });
      }
    });
      }); 
</script>
</body>
</html>