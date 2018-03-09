<?php
if(isset($item->fields->organization))
	{
	$organization_id = $item->fields->organization[0];
	}
else
	{
	$organization_id = array();	
	}

if(isset($item->fields->locations))
	{
	$location_id = $item->fields->locations[0];
	}
else
	{
	$location_id = array();	
	}		

$service = array();
$service['id'] = $service_id;
$service['organization_id'] = $organization_id;
$service['location_id'] = $location_id;
$service['name'] = $item->fields->name;
// if altername_name
if(isset($service['alternate_name']))
	{
	$service['alternate_name'] = $item->fields->alternate_name;
	}
else
	{
	$service['alternate_name'] = "";
	}	
	
$service['description'] = $item->fields->description;
$service['url'] = $item->fields->url;
$service['application_process'] = $item->fields->application_process;

/// phones
$service['phones'] = array();
foreach($phone_results->records as $item)
	{
		
	$phone_id = $item->id;
	
	$phone = array();
	$phone['id'] = $phone_id;
	
	if(isset($item->fields->locations))
		{
		foreach($item->fields->locations as $this_location_id)
			{
			if($this_location_id==$location_id)
				{
				$phone['number'] = $item->fields->number;
				// if type
				if(isset($item->fields->type))
					{
					$phone['type'] = $item->fields->type;
					}
				else
					{
					$phone['type'] = "";
					}						
		
				array_push($service['phones'],$phone);
				}
			}
		}		
	}
	
/// schedule
$service['regular_schedule'] = array();
$service['holiday_schedule'] = array();
foreach($schedule_results->records as $item)
	{
		
	$schedule_id = $item->id;
	
	$schedule = array();
	$schedule['id'] = $schedule_id;

	if(isset($item->fields->locations))
		{
		foreach($item->fields->locations as $this_location_id)
			{
			if($this_location_id==$location_id)
				{
				
				if(isset($item->fields->holiday) && $item->fields->holiday == true)
					{

					// if closed
					if(isset($item->fields->closed))
						{
						$schedule['closed'] = $item->fields->closed;
						}
					else
						{
						$schedule['closed'] = "";
						}							
					
					$schedule['start_date'] = $item->fields->start_date;
					$schedule['end_date'] = $item->fields->end_date;
					array_push($service['holiday_schedule'],$schedule);
					}
				else
					{
					$schedule['weekday'] = $item->fields->days_of_week;
					$schedule['opens_at'] = $item->fields->opens_at;
					$schedule['closes_at'] = $item->fields->closes_at;
					array_push($service['regular_schedule'],$schedule);
					}
				}
			}
		}		
	}
	?>