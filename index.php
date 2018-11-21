<link rel="stylesheet" type="text/css" href="css/stile.css" media="screen and (min-width: 861px)">
<link rel="stylesheet" type="text/css" href="css/stile_mob.css" media="screen and (max-width: 860px)">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
<?php  require_once("classes/invoices.php"); ?>
<?php  require_once("classes/database.php"); ?>
<?php  require_once "functions/set_edit_mode.php"; ?>
<?php  require_once "functions/send_edit_status.php"; ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script src="js/scripts.js"></script>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
  <title>Invoice Manager</title>
</head>
<body>
<!-- Contenitore dell'intero sito -->
  <div id="PageWrapper">
    <div id="Header">Invoice Manager</div>
    <!-- Contenitore dei menu laterali e del contenuto centrale -->
    <div id="Menu-Content-Wrap">
		<nav>
			<div id="nav-icon3">
				<span></span>
				<span></span>
				<span></span>
				<span></span>
			</div>
			<div id="Menu-Left">
				<ul>
					<li><a href="index.php?page=0" id="home" class="MenuButton">Home</a></li>
				</ul>
			</div>
		</nav>
		<hr id="linea">
		<div id="MainContent">
			<br>
			<h2 align="center">INVOICES</h2><br>
			<br>
			<div class="form-group">
		        <button style="margin-bottom: 7px;" onclick="export_transictions()" class="btn btn-primary">Export Transictions .CSV</button><br>
		        <button onclick="export_cr()" class="btn btn-primary">Export Customer Report .CSV</button><br><br>
		        <label for='edit_mode'>Go to Edit Mode!</label>
				<form id="edit_mode" action='' method='post'>
				  <button onclick="edit_mode()" class="btn btn-warning" type='submit' name='EM_true'>ON</button>
				  <button class="btn btn-warning" type='submit' name='EM_false'>OFF</button>
				</form>
				<!-- SEARCHBAR (NOT SERVER-SIDE YET) -->
		       <!-- <div id="searchbar">
			        <form action="/action_page.php">
			        	<label for='search_by_name'>Search By Client Name:</label>
						<input type="text" placeholder="Search.." name="search" id='search_by_name'>
						<button type="submit"><i class="fa fa-search"></i></button>
				    </form>
				</div>
		    </div>-->

<?php
	$actual_page=0;
	$db = new database();
	$db->db_connect();
	$invoice = new invoice($db);
	$num_rows=$db->db_count_rows("SELECT * FROM invoices");
	$db->db_disconnect();
	$n_pages=ceil($db->n_rows/5); //count pages 
	
	//TRIGGERS
	if(isset($_GET['page'])){
		$actual_page = $_GET['page'];
		if($actual_page <0)
			$actual_page = 0;
		elseif($actual_page > $n_pages-1)
			$actual_page = $n_pages-1;
		//VERIFY EDIT MODE BY COOKIE
		if(isset($_COOKIE['edit_mode']) && $_COOKIE['edit_mode']=='true')
		    $invoice->select_query("invoice_main",0,$actual_page,true);
		else
	    	$invoice->select_query("invoice_main",0,$actual_page,false);
	}
	if(isset($_GET['invoice_details'])){
		$id=$_GET['invoice_details'];
	    $invoice->select_query("invoice_detailed",$id,$actual_page,false);
	}
	if(isset($_GET['edit_mode'])){
	    $invoice->select_query("invoice_main",0,$actual_page,true);
	}
	
?>
    <!--  /Content   -->
    <div id="Footer">By Davide Pisu</div>
  </div>
</body>
</html>