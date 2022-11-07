<?php
    // Include config.php file
    include_once('dbconfig.php');
    $dbObj = new Database();
    // Insert Record    
    if (isset($_POST['action']) && $_POST['action'] == "insert") {
        $name = $_POST['name'];
        $age = $_POST['Age'];
        $course = $_POST['course'];
        
        $dbObj->insertRecord($name, $age, $course);
    }
    // View record
    if (isset($_POST['action']) && $_POST['action'] == "view") {
        $output = "";
        $students = $dbObj->displayRecord();
        if ($dbObj->totalRowCount() > 0) {
            $output .="<table class='table table-striped table-hover'>
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Username</th>
                        
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>";
            foreach ($students as $student) {
            $output.="<tr>
                        <td>".$student['id']."</td>
                        <td>".$student['studname']."</td>
                        <td>".$student['studage']."</td>
                        <td>".$student['studcourse']."</td>
                        
                        <td>
                          <a href='#editModal' style='color:green' data-toggle='modal' 
                          class='editBtn' id='".$student['id']."'><i class='fa fa-pencil'></i></a>&nbsp;
                          <a href='' style='color:red' class='deleteBtn' id='".$student['id']."'>
                          <i class='fa fa-trash' ></i></a>
                        </td>
                    </tr>";
                }
            $output .= "</tbody>
            </table>";
            echo $output;   
        }else{
            echo '<h3 class="text-center mt-5">No records found</h3>';
        }
    }
    // Edit Record  
    if (isset($_POST['editId'])) {
        $editId = $_POST['editId'];
        $row = $dbObj->getRecordById($editId);
        echo json_encode($row);


    }
    if (isset($_POST['action']) && $_POST['action'] == "update") {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $age = $_POST['Age'];
        $course = $_POST['course'];
        
        $dbObj->updateRecord($id, $name, $age, $course,);
    }
    if (isset($_POST['deleteBtn'])) {
        $deleteBtn = $_POST['deleteBtn'];
        $dbObj->deleteRecord($deleteBtn);
    }


?>