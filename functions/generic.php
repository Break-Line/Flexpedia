<?php
	function set_query($type,$offset,$id,$status){
		switch($type){
			case 'invoice_main':
				$sql = "SELECT
							id AS 'Invoice ID',
							client AS 'Client',
							invoice_amount AS 'Invoice amount',
							vat_rate AS '% VAT',
							invoice_amount_plus_vat AS 'TOT',
							invoice_status AS 'Status',
							invoice_date AS 'Invoice date',
							created_at AS 'Created at'
						FROM
							invoices
						ORDER BY
							(id) DESC
						LIMIT 5 OFFSET ".$offset.";";
			break;
		case 'invoice_detailed':
			$sql = "SELECT
						invoice_items.invoice_id AS 'Invoice ID',
						client AS 'Client',
						NAME AS 'Service name',
						invoice_items.amount AS 'Amount',
						invoice_items.created_at AS 'Created at'
					FROM
						invoices,
						invoice_items
					WHERE
						(
							invoice_items.invoice_id = ".$id."
							AND invoices.id = ".$id."
						)
					ORDER BY
						(invoice_items.amount) DESC";
			break;
			case 'invoices_csv_transictions':
				$sql = "SELECT
							id,
							client,
							invoice_amount,
							invoice_amount_plus_vat
						FROM
							invoices
						ORDER BY
							(id) DESC";
			break;
		case 'invoices_csv_creport':
			$sql = "SELECT
					client,
					SUM(invoice_amount_plus_vat) AS 'TOT invoiced + VAT',
					SUM(
						CASE
						WHEN invoice_status = 'paid' THEN
							invoice_amount_plus_vat
						ELSE 0
						END
					) AS 'TOT paid + VAT',
					SUM(
						CASE
						WHEN invoice_status = 'unpaid' THEN
							invoice_amount_plus_vat
						ELSE 0
						END
					) AS 'TOT outstanding + VAT'
				FROM
					invoices
				GROUP BY
					(client)
				ORDER BY
					(client)";
			break;
		case 'edit_status':
			$sql = "UPDATE invoices
					SET invoice_status = '".$status."'
					WHERE
						(id = ".$id.")";
			break;
		/*case 'get_status_by_id':
			$sql = "SELECT
						invoice_status
					FROM
						invoices
					WHERE
						(id = "$id")";
			break;*/
		}
		return $sql;
	}
?>