<?php

	include "/home/edukiwi/public_html/wp-load.php";

	function insertVisit2($affiliate_name) {
		global $wpdb;
		$table = $wpdb->prefix.'wp_affiliates';
		$affiliate_row = $wpdb->get_row("SELECT * FROM wp_affiliates WHERE `affiliate` = '$affiliate_name'");
		if(!sizeof($affiliate_row)) {
			setcookie("affiliate_id", $affiliate_name, time() + (86400 * 7), '/', 'edukiwi.ro', 1);
			$wpdb->insert(
				"wp_affiliates",
				array(
					'affiliate' => $affiliate_name,
					'visits' => 1
				)
			);
		} else {
			if(!isset($_COOKIE['affiliate_id'])) {
				$visits = $affiliate_row->visits;
				$visits_added = $visits + 1;
				$wpdb->update(
					"wp_affiliates",
					array( 
						'visits' => $visits_added
					),
					array(
						'affiliate' => $affiliate_name
					)
				);
			}
		}
	} 

	function insertConversion($affiliate_name) {

			/*error_reporting(E_ALL);
			ini_set('display_errors', 1);*/
			
			if( isset($_COOKIE['affiliate_converted'])) 
				return; 

			$cookie = setcookie("affiliate_converted", "true", time() + (86400 * 7), '/', 'edukiwi.ro', 1);

			//var_dump($cookie);

			global $wpdb;
			$table = $wpdb->prefix.'wp_affiliates';
			$affiliate_row = $wpdb->get_row("SELECT * FROM wp_affiliates WHERE `affiliate` = '$affiliate_name'");

			if(!sizeof($affiliate_row)) {
				$wpdb->insert(
					"wp_affiliates",
					array(
						'affiliate' => $affiliate_name
					)
				);
			} else {
				$conversions = $affiliate_row->conversions;
				$conversions_added = $conversions + 1;
				$wpdb->update(
					"wp_affiliates",
					array( 
						'conversions' => $conversions_added
					),
					array(
						'affiliate' => $affiliate_name
					)
				);
			}

	}

	function getAffiliateData($affiliate_name) {
		global $wpdb;
		$table = $wpdb->prefix.'wp_affiliates';
		$affiliate_row = $wpdb->get_row("SELECT * FROM wp_affiliates WHERE `affiliate` = '$affiliate_name'");
		$afvisits = $affiliate_row->visits;
		$afconversions = $affiliate_row->conversions;
		echo "<span>Vizite pe link-ul tau unic de programare întâlnire*: ".$afvisits."</span><br><span>Întâlniri programate de pe link-ul tău unic: ".$afconversions."</span>";
	}

	

?>