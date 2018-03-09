<?php
$route = '/locations/full/:location_id/';
$app->get($route, function ($this_location_id)  use ($app,$api_key,$base_url){

	$ReturnObject = array();
	
	$this_location_id = filter_var($this_location_id,FILTER_SANITIZE_STRING);

	try 
		{

		//phones
		$api_phone_url = $base_url . '/phones?api_key=' . $api_key;
		//echo $api_url . "<br />";
		$http = curl_init(); 
		curl_setopt($http, CURLOPT_URL, $api_phone_url); 
		curl_setopt($http, CURLOPT_RETURNTRANSFER, 1); 
		$output = curl_exec($http); 
		curl_close($http); 
		$phone_results = json_decode($output);	
		
		//address
		$api_address_url = $base_url . '/address?api_key=' . $api_key;
		//echo $api_address_url . "<br />";
		$http = curl_init(); 
		curl_setopt($http, CURLOPT_URL, $api_address_url); 
		curl_setopt($http, CURLOPT_RETURNTRANSFER, 1); 
		$output = curl_exec($http); 
		curl_close($http); 
		$address_results = json_decode($output);
		
		//schedule
		$api_schedule_url = $base_url . '/schedule?api_key=' . $api_key;
		//echo $api_schedule_url . "<br />";
		$http = curl_init(); 
		curl_setopt($http, CURLOPT_URL, $api_schedule_url); 
		curl_setopt($http, CURLOPT_RETURNTRANSFER, 1); 
		$output = curl_exec($http); 
		curl_close($http); 
		$schedule_results = json_decode($output);		
	
		//locations
		$api_url = $base_url . '/locations?api_key=' . $api_key;
		$http = curl_init(); 
		curl_setopt($http, CURLOPT_URL, $api_url); 
		curl_setopt($http, CURLOPT_RETURNTRANSFER, 1); 
		$output = curl_exec($http); 
		curl_close($http); 
		
		$location__results = json_decode($output);
			
		foreach($location__results->records as $item)
			{
				
			// location	
			$location_id = $item->id;
			
			if($location_id == $this_location_id)
				{
			
				// central function that is reused
				include "includes/locations.php";	
				
				array_push($ReturnObject,$location);
				
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
