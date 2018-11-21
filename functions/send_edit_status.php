<?php
	//TRIGGER BY SELECT/OPTION IN EDIT MODE
	if (isset($_POST['edit_status']) && isset($_POST['id_row']))  { 
		$status = $_POST['edit_status'];
		$id = $_POST['id_row'];
		$type = "edit_status";
        // refresh current page
		$edit_db = new database;
		$edit_db->db_connect();
		$query = set_query($type,0,$id,$status);
		$edit_db->solve_query($query);
		$edit_db->db_disconnect();
		header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    } 

?>