<?php

$route = '/organizations/full/:organization_id/';
$app->get($route, function ($get_organization_id)  use ($app,$api_key,$base_url){

	$ReturnObject = array();

	$get_organization_id = filter_var($get_organization_id,FILTER_SANITIZE_STRING);

	try 
		{

		// pull locations
		$api_location_url = $base_url . '/locations?api_key=' . $api_key;
		//echo $api_url . "<br />";
		$http = curl_init(); 
		curl_setopt($http, CURLOPT_URL, $api_location_url); 
		curl_setopt($http, CURLOPT_RETURNTRANSFER, 1); 
		$output = curl_exec($http); 
		curl_close($http); 
		$location_results = json_decode($output);
		
		// pull contacts
		$api_contact_url = $base_url . '/contact?api_key=' . $api_key;
		//echo $api_url . "<br />";
		$http = curl_init(); 
		curl_setopt($http, CURLOPT_URL, $api_contact_url); 
		curl_setopt($http, CURLOPT_RETURNTRANSFER, 1); 
		$output = curl_exec($http); 
		curl_close($http); 
		$contact_results = json_decode($output);	
		
		// pull services
		$api_contact_url = $base_url . '/services?api_key=' . $api_key;
		//echo $api_url . "<br />";
		$http = curl_init(); 
		curl_setopt($http, CURLOPT_URL, $api_contact_url); 
		curl_setopt($http, CURLOPT_RETURNTRANSFER, 1); 
		$output = curl_exec($http); 
		curl_close($http); 
		$service_results = json_decode($output);	
	
		$api_url = $base_url . '/organizations?api_key=' . $api_key;
		//echo $api_url . "<br />";
		$http = curl_init(); 
		curl_setopt($http, CURLOPT_URL, $api_url); 
		curl_setopt($http, CURLOPT_RETURNTRANSFER, 1); 
		$output = curl_exec($http); 
		curl_close($http); 
		
		$results = json_decode($output);
			
		foreach($results->records as $item)
			{
				
			// organizations
			$object = $item->fields;	
			$organization_id = $item->id;
		
			if($organization_id == $get_organization_id)
				{			
			
				// central organization function
				include "includes/organizations.php";
			
				array_push($ReturnObject,$organization);
				}
			}
	
		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));			
			
		}
	catch (Exception $e)
		{
		$errorData = array("There was a problem Houston!");
		$app->render('error-500.php', $errorData, 500);			
		}
		
	});

?>
