<?php
require_once("classes/invoices.php");
require_once("classes/database.php");
require_once("functions/generic.php");

	if(isset($_GET['transictions'])){
		$csv_headers =  array('ID', 'Company Name', 'Invoice Amount €', 'Inv. Amount Plus VAT €');
		$fname="Transictions";
		$type='invoices_csv_transictions';
	}
	elseif(isset($_GET['c_report'])){
		$csv_headers =  array('Company Name', 'TOT Invoiced + VAT €', 'TOT Amount Paid €', 'TOT Amount Outstanding €');
		$fname="Customer_Report";
		$type='invoices_csv_creport';
	}else{
		return 0;
	}
	$csv_db = new database;
	$csv_db->db_connect();
	$query = set_query($type,0,0,0);
	export($query,$csv_db,$csv_headers,$fname);

	function export($query,$csv_db,$csv_headers,$fname){	
		$path = "generated/".$fname.".csv";
		$csv_db->solve_query($query);
		$num_rows = $csv_db->db_count_rows($query);
		$invoices = array();
		for($x=0;$x<$num_rows;$x++)
			$invoices[] = $csv_db->db_set_array($invoices);
		$csv_db->db_disconnect();
		$output = fopen($path, 'w');
		fputcsv($output, $csv_headers); 
		 
		if (count($invoices) > 0) {
		    foreach ($invoices as $row) {
		        fputcsv($output, $row);
		    }
		}
		if (file_exists($path)) {
		    header('Content-Type: text/csv');
		    header('Content-Disposition: attachment; filename='.basename($path));
		    header('Expires: 0');
		    header("Pragma: no-cache");
		    header('Content-Length: ' . filesize($path));
		    ob_clean();
		    flush();
		    readfile($path);
		    die();
		}else{
			echo "<br>Error: file does not exist.<br>";
			die();
		}
	}
?>