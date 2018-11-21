<script src="js/scripts.js"></script>
<?php
require_once "classes/database.php";
require_once "functions/generic.php";

class invoice{
		public $db;
		private $mysqli;
		private $result;
		public $offset;
		public $n_rows;
		public $n_pages;
		public $n_columns;
		public $actual_page;
		private $next;
		private $prev;
		private $edit;

		public function __construct(database $db){
			$this->db = $db;
			$this->offset = 0;
			$this->actual_page = null;
			$this->n_pages=0;
		}
		
  		public function select_query($tab_type, $id,$page,$edit){ 
  			$this->edit=$edit;	//edit_mode true/false
  			if($tab_type=="invoice_main"){	//check errors
	  			if ( filter_var($page, FILTER_VALIDATE_INT) === false ) {
				  	echo "ERROR: Your page is not an integer<br>first page displayed<br>";
				  	$page = 0;
				}
			}
			elseif($tab_type=="invoice_detailed"){	//check errors
				if ( filter_var($id, FILTER_VALIDATE_INT) === false ) {
				  	echo "ERROR: Your invoice ID is not an integer<br><br>";
				  	$id=0;
				  	return 0;
				}
			}
  			$this->actual_page=$page;
  			$this->next = $this->actual_page + 1;
			$this->prev = $this->actual_page - 1;
  			$this->offset = $this->actual_page*5;
  			$sql = set_query($tab_type,$this->offset,$id,0);
  			$this->db->db_connect();
  			$this->result = $this->db->solve_query($sql);
  			if ($this->n_pages==0)
  				$this->n_pages = ceil($this->db->db_count_rows("SELECT * FROM invoices")/5-1);	//CALCULATE THE NUMBER OF PAGES TO WRITE
  			$this->db->db_disconnect();
  			$this->n_rows = $this->result->num_rows;
  			$this->n_columns = $this->result->field_count;
  			$this->show_table($tab_type);
  		}
  		private function show_table($tab_type){
  			$curr_column = $this->result->fetch_fields();
		  	print ("<hr><div id='inv_table' class='tftable'><table class='table table-bordered'><tr>");
			for($y=0;$y<$this->n_rows;$y++){
				$curr_row = $this->result->fetch_array();
				if($y==0){	//TAKE HEADERS
					for($x=0;$x<$this->n_columns;$x++){
						print ("<th>
							".$curr_column[$x]->name."
						</th>
						");
					}
				}	
				print("</tr><tr>");
				for($x=0;$x<$this->n_columns;$x++){
					if($x==0 && $tab_type=="invoice_main"){
						print ("<td><a href='?invoice_details=".$curr_row[$x]."&page=".$this->actual_page."'>
							".$curr_row[$x]."</a>
						</td>
						");
						$current_row_id=$curr_row[$x];
					}	
					elseif($x==5 && $tab_type=="invoice_main"){ 	//$x=5  =  INVOICE STATUS COLUMN
						if($this->edit==true){	//IF EDIT_MODE IS ON, THEN DISPLAY SELECT OPTION FORMS
							print("
								<td>
									<form class='status' action='' method='post'>
										<input type='hidden' name='id_row' value='".$current_row_id."'>
										<select onchange='' class='form-control' name='edit_status'>
										<option ");
							if($curr_row[$x]=="paid"){
								print("selected='selected'>".strtoupper($curr_row[$x]).
									"<option value='unpaid'>UNPAID</option>"
								);
							}elseif($curr_row[$x]=="unpaid"){
								print("selected='selected'>".strtoupper($curr_row[$x]).
									"<option value='paid'>PAID</option>"
								);
							}
							print(">".$curr_row[$x]."</option></select><button class='btn btn-success' type='submit'>SEND</button></form>
								</td>");
						}
						else{
							print ("<td>
							".$curr_row[$x]."
						</td>
						");
						}
					}			
								
					else{
						print ("<td>
							".$curr_row[$x]."
						</td>
						");
					}		
				}
			}
			print ("</tr></table></div><br>");
			if($tab_type=="invoice_main"){	//SHOW NAV BUTTONS ON MAIN INVOICES
				print ("
						<p>Page ".$this->actual_page." of ".$this->n_pages."</p>
						<a href='?page=".$this->prev."'> <input type='button' class='btn btn-secondary' value='Prev' ></a>
						<a href='?page=".$this->next."'> <input type='button' class='btn btn-secondary' value='Next' ></a>
						<br><br>
						<div class='form-group'>
						<label for='sel_page'>Select page:</label>
						<select onchange='change_invoice_page()' class='form-control' id='sel_page'>");
				for($sel_page=0;$sel_page<=$this->n_pages;$sel_page++){
					print ("<option");
					if($sel_page==$this->actual_page){
						print(" selected='selected'");
					}
					print(">".$sel_page."</option>");
				}
							
				print("
						</select>
						</div>
						
						 ");
			}
			
		}
	}
?>