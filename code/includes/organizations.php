<?php
$organization = array();
$organization['id'] = $organization_id;
$organization['name'] = $object->name;

// alternate name
if(isset($object->alternate_name))
	{
	$organization['alternate_name'] = $object->alternate_name;
	}
else
	{
	$organization['alternate_name'] = "";	
	}

// url
if(isset($object->url))
	{
	$organization['url'] = $object->url;
	}
else
	{
	$organization['url'] = "";	
	}		


/// Contacts
$organization['contacts'] = array();
foreach($contact_results->records as $item)
	{
	//var_dump($item);	
		
	$id = $item->id;
	
	$contact = array();
	$contact['id'] = $id;
	
	$organization_ids = $item->fields->organizations;
	foreach($organization_ids as $this_organization_id)
		{
		if($this_organization_id==$organization_id)
			{
			$contact['organization_id'] = $item->fields->organizations;
			$contact['name'] = $item->fields->name;
			$contact['title'] = $item->fields->title;
			$contact['email'] = $item->fields->email;
	
			array_push($organization['contacts'],$contact);
			}
		}
	}	
	
/// Contacts
$organization['locations'] = array();
foreach($location_results->records as $item)
	{
	//var_dump($item);	
		
	$contact_id = $item->id;
	
	$contact = array();
	$contact['id'] = $contact_id;
	
	//var_dump($item->fields);
	
	$organization_ids = $item->fields->organization;
	foreach($organization_ids as $this_organization_id)
		{
		if($this_organization_id==$organization_id)
			{
			$location['organization_id'] = $item->fields->organization;
			$location['name'] = $item->fields->name;
			$location['latitude'] = $item->fields->latitude;
			$location['longitude'] = $item->fields->longitude;
			
			// If description
			if(isset($item->fields->description))
				{
				$location['description'] = $item->fields->description;
				}
			else
				{
				$location['description'] = "";
				}
	
			array_push($organization['locations'],$location);
			}
		}
	}	
	
/// Services
$organization['services'] = array();
foreach($service_results->records as $item)
	{
	//var_dump($item);	
		
	$service_id = $item->id;
	
	$service = array();
	$service['id'] = $service_id;
	
	//var_dump($item->fields);
	
	$organization_ids = $item->fields->organization;
	foreach($organization_ids as $this_organization_id)
		{
		if($this_organization_id==$organization_id)
			{
			$service['name'] = $item->fields->name;
			
			// if alternate_name
			if(isset($item->fields->alternate_name))
				{
				$location['alternate_name'] = $item->fields->alternate_name;
				}
			else
				{
				$location['alternate_name'] = "";
				}					
			
			$service['description'] = $item->fields->description;
			$service['url'] = $item->fields->url;
			$service['application_process'] = $item->fields->application_process;
	
			array_push($organization['services'],$service);
			}
		}
	}
?>