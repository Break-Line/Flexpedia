<?php
	class database{
		private $host;
		private $user;
		private $pass;
		private $db;
		private $mysqli;
		public $result;
		public $n_rows;
		public $n_columns;

		public function __construct(){
				//$this->db_connect();
			}
		public function db_connect(){
			$this->host = 'localhost';
		    $this->user = 'root';
		    $this->pass = '';
		    $this->db = 'exercise_fp';
		    $this->mysqli = new mysqli($this->host, $this->user, $this->pass, $this->db);
		    if ($this->mysqli->connect_errno) {
		        echo '<p><b>There was an error connecting to the database!</b></p>';
		        echo $this->mysqli->connect_error;
	        	die();
	    	}
		    return $this->mysqli;
		}
		public function db_count_rows($sql){
	        $this->solve_query($sql);
	        $this->n_rows = $this->result->num_rows;
	        return $this->n_rows;
		}
		public function solve_query($sql){
			if(!$this->result = $this->mysqli->query($sql)){
				printf("Errormessage: %s\n", $this->mysqli->error);
				die();
			}
			return $this->result;
		}
		public function db_disconnect(){
			$this->mysqli->close();
		}
		public function db_set_array($array){
			while ($row = $this->result->fetch_assoc()) {
        		$array[] = $row;
        		return $row;
    		}
		}
	}

?>