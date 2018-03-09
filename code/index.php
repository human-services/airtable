<?php
set_time_limit(500);

date_default_timezone_set('America/Los_Angeles');
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once('config.php');
require_once('Slim/Slim.php');

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

$request = $app->request();
$params = $request->params();
$mediaType = $request->getMediaType();
$contentType = $request->getContentType();

if(isset($params['api_key'])){ $api_key = $params['api_key']; } else { $api_key = ""; }

if(isset($params['api_key']))
	{
	// locations	
	include "methods/locations-get.php";
	include "methods/locations-location_id-get.php";
	
	// organizations
	include "methods/organizations-get.php";
	include "methods/organizations-organization_id-get.php";
	
	// services
	include "methods/services-get.php";
	include "methods/services-service_id-get.php";
	
	$app->run();
	}
else
	{
	$errorData = array("Sorry you do not have access!");
	$app->render('error-403.php', $errorData, 403);
	}
?>
