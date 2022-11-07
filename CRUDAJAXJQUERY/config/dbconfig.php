<?php
	
	class Database 
	{
		private $servername = "localhost";
		private $username   = "root";
		private $password   = "";
		private $dbname = "crudajax";
		public $con;
		public $studentstbl = "studentstbl";
		public $email ="";
		public $pw =""; 
		public function __construct()
		{
			try {
				$this->con = new mysqli($this->servername, $this->username, $this->password, $this->dbname);	
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
		    

        public function Login($email, $pass){  
            $res = "SELECT * FROM users WHERE email = '".$email."' AND password1 = '".$pass."'";
             $query = $this->con->query($res); 
            
             if($row=mysql_fetch_array($query))  
            {  
           
               return true;
            }  
            else  
            {  
                echo "fail";
            }  
        }

     public function logout() {  
        $_SESSION['login'] = false;  
        session_destroy();  
    }  
    function session() {  
        if (isset($_SESSION['login'])) {  
            return $_SESSION['login'];  
        }  
    }  
 
		// Insert customer data into customer table
		public function insertRecord($name, $age, $course)
		{
			$sql = "INSERT INTO $this->studentstbl (studname, studage, studcourse) VALUES('$name', '$age', '$course')";
			$query = $this->con->query($sql);
			if ($query) {
				return true;
			}else{
				return false;
			}
		}
		
		public function displayRecord()
		{
			$sql = "SELECT * FROM $this->studentstbl";   //takes the number of rows in the database and calls upon the associated data for each row through using while 												giving initializing it  
			$query = $this->con->query($sql);				//as data
			$data = array();
			if ($query->num_rows > 0) {
				while ($row = $query->fetch_assoc()) {
					$data[] = $row;
				}
				return $data;
			}else{
				return false;
			}
		}
		public function getRecordById($id)
		{
			$query = "SELECT * FROM $this->studentstbl WHERE id = '$id'"; //takes the id and the other rows and places it as a json to be passed to the edit ajax
			$result = $this->con->query($query);
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				return $row;
			}else{
				return false;
			}
		}
		public function totalRowCount(){
			$sql = "SELECT * FROM $this->studentstbl";
			$query = $this->con->query($sql);
			$rowCount = $query->num_rows;
			return $rowCount;
		}


		public function updateRecord($id, $name, $age, $course)
		{
			$sql = "UPDATE $this->studentstbl SET studname = '$name', studage = '$age', studcourse = '$course' 
			WHERE id = '$id'";
			$query = $this->con->query($sql);
			if ($query) {
				return true;
			}else{
				return false;
			}
		}

		// Delete customer data from customer table
		public function deleteRecord($id)
		{
			$sql = "DELETE FROM $this->studentstbl WHERE id = '$id'";
			$query = $this->con->query($sql);
			if ($query) {
				return true;
			}else{
				return false;
			}
		}
	}
	
?>