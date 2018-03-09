<?php

$route = '/services/full/';
$app->get($route, function ()  use ($app,$api_key,$base_url){

	$ReturnObject = array();

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
		
		//schedule
		$api_schedule_url = $base_url . '/schedule?api_key=' . $api_key;
		//echo $api_schedule_url . "<br />";
		$http = curl_init(); 
		curl_setopt($http, CURLOPT_URL, $api_schedule_url); 
		curl_setopt($http, CURLOPT_RETURNTRANSFER, 1); 
		$output = curl_exec($http); 
		curl_close($http); 
		$schedule_results = json_decode($output);	
	
		$api_url = $base_url . '/services?api_key=' . $api_key;
		
		$http = curl_init(); 
		curl_setopt($http, CURLOPT_URL, $api_url); 
		curl_setopt($http, CURLOPT_RETURNTRANSFER, 1); 
		$output = curl_exec($http); 
		curl_close($http); 
		$service_results = json_decode($output);
	
		foreach($service_results->records as $item)
			{
			$service_id = $item->id;
			
			// central function
			include "includes/services.php";
			
			array_push($ReturnObject,$service);
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
