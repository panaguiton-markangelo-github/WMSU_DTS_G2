<?php

Class Connection{
 
	private $server = "mysql:host=localhost;dbname=dts_db;";
	private $username = "root";
	private $password = "kookies172001";
	private $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,);
	protected $conn;
 	
	public function open(){
 		try{
 			$this->conn = new PDO($this->server, $this->username, $this->password, $this->options);
 			return $this->conn;
 		}
 		catch (PDOException $e){
 			echo "There is some problem in connection: " . $e->getMessage();
 		}
 
    }
 
	public function close(){
   		$this->conn = null;
 	}

	 // Fetch Type

	 public function fetch_type()
	 {
		 $data = [];
 
		 $query = "SELECT DISTINCT `type` FROM `documents` ORDER BY `type` ASC";
		 if ($sql = $this->conn->query($query)) {
			 while ($row = mysqli_fetch_assoc($sql)) {
				 $data[] = $row;
			 }
		 }
 
		 return $data;
	 }
 
	 // Fetch School Year
 
	 public function fetch_school_year()
	 {
		 $data = [];
 
		 $query = "SELECT DISTINCT `schoolYear` FROM `documents`";
		 if ($sql = $this->conn->query($query)) {
			 while ($row = mysqli_fetch_assoc($sql)) {
				 $data[] = $row;
			 }
		 }
 
		 return $data;
	 }
 
	 // Fetch Records
 
	 public function fetch()
	 {
		 $data = [];
 
		 $query = "SELECT DISTINCT documents.*, yearsemester.schoolYear, users.officeName FROM documents 
		 INNER JOIN yearsemester ON yearsemester.id = documents.yearSemID 
		 INNER JOIN users ON users.id = documents.user_id
		 ORDER BY documents.id DESC;";
		 if ($sql = $this->conn->query($query)) {
			 while ($row = mysqli_fetch_assoc($sql)) {
				 $data[] = $row;
			 }
		 }
 
		 return $data;
	 }
 
	 // Filter Type and School Year
 
	 public function fetch_filter($type, $school_year)
	 {
		 $data = [];
 
		 $query = "SELECT * FROM documents WHERE type = '$type' AND schoolYear = '$school_year' ";
		 if ($sql = $this->conn->query($query)) {
			 while ($row = mysqli_fetch_assoc($sql)) {
				 $data[] = $row;
			 }
		 }
 
		 return $data;
	 }
 
	 // Filter Type
 
	 public function fetch_type_filter($type)
	 {
		 $data = [];
 
		 $query = "SELECT * FROM documents WHERE type = '$type'";
		 if ($sql = $this->conn->query($query)) {
			 while ($row = mysqli_fetch_assoc($sql)) {
				 $data[] = $row;
			 }
		 }
 
		 return $data;
	 }
 
	 // Filter School Year
 
	 public function fetch_school_year_filter($school_year)
	 {
		 $data = [];
 
		 $query = "SELECT * FROM documents WHERE schoolYear = '$school_year'";
		 if ($sql = $this->conn->query($query)) {
			 while ($row = mysqli_fetch_assoc($sql)) {
				 $data[] = $row;
			 }
		 }
 
		 return $data;
	 }

}
 
?>