<?php
$route = '/locations/full/';
$app->get($route, function ()  use ($app,$api_key,$base_url){

	$ReturnObject = array();

	try 
		{

		// pulls all phones
		$api_phone_url = $base_url . '/phones?api_key=' . $api_key;
		//echo $api_url . "<br />";
		$http = curl_init(); 
		curl_setopt($http, CURLOPT_URL, $api_phone_url); 
		curl_setopt($http, CURLOPT_RETURNTRANSFER, 1); 
		$output = curl_exec($http); 
		curl_close($http); 
		$phone_results = json_decode($output);	
		
		// pulls all addresses
		$api_address_url = $base_url . '/address?api_key=' . $api_key;
		//echo $api_address_url . "<br />";
		$http = curl_init(); 
		curl_setopt($http, CURLOPT_URL, $api_address_url); 
		curl_setopt($http, CURLOPT_RETURNTRANSFER, 1); 
		$output = curl_exec($http); 
		curl_close($http); 
		$address_results = json_decode($output);
		
		// pull all schedules
		$api_schedule_url = $base_url . '/schedule?api_key=' . $api_key;
		//echo $api_schedule_url . "<br />";
		$http = curl_init(); 
		curl_setopt($http, CURLOPT_URL, $api_schedule_url); 
		curl_setopt($http, CURLOPT_RETURNTRANSFER, 1); 
		$output = curl_exec($http); 
		curl_close($http); 
		$schedule_results = json_decode($output);		
	
		// pulls all locations
		$api_url = $base_url . '/locations?api_key=' . $api_key;
		$http = curl_init(); 
		curl_setopt($http, CURLOPT_URL, $api_url); 
		curl_setopt($http, CURLOPT_RETURNTRANSFER, 1); 
		$output = curl_exec($http); 
		curl_close($http); 
		
		$organization_results = json_decode($output);
			
		foreach($organization_results->records as $item)
			{
				
			// location	
			$location_id = $item->id;

			// central function that is reused
			include "includes/locations.php";			
				
			
			array_push($ReturnObject,$location);
			}
		
		// return response	
		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));			
			
		}
	catch (Exception $e)
		{
		// return errors
		$errorData = array("There was a problem Houston!");
		$app->render('error-500.php', $errorData, 500);			
		}
	
	});

?>
