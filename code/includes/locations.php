<?php
$location = array();
$location['id'] = $location_id;
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
	
/// phones
$location['phones'] = array();
foreach($phone_results->records as $item)
	{
		
	$phone_id = $item->id;
	
	$phone = array();
	$phone['id'] = $phone_id;
	
	if(isset($item->fields->locations))
		{
		$location_ids = $item->fields->locations;
		foreach($location_ids as $this_location_id)
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
		
				array_push($location['phones'],$phone);
				}
			}
		}		
	}
	
/// schedule
$location['regular_schedule'] = array();
$location['holiday_schedule'] = array();
foreach($schedule_results->records as $item)
	{
		
	$schedule_id = $item->id;
	
	$schedule = array();
	$schedule['id'] = $schedule_id;

	if(isset($item->fields->locations))
		{
		$location_ids = $item->fields->locations;
		foreach($location_ids as $this_location_id)
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
					array_push($location['holiday_schedule'],$schedule);
					}
				else
					{
					$schedule['weekday'] = $item->fields->days_of_week;
					$schedule['opens_at'] = $item->fields->opens_at;
					$schedule['closes_at'] = $item->fields->closes_at;
					array_push($location['regular_schedule'],$schedule);
					}
				}
			}
		}		
	}
			
/// phones
$location['postal_address'] = array();
$location['physical_address'] = array();
foreach($address_results->records as $item)
	{
		
	$address_id = $item->id;
	
	$address = array();
	$address['id'] = $address_id;

	if(isset($item->fields->locations))
		{
		$location_ids = $item->fields->locations;
		foreach($location_ids as $this_location_id)
			{
			if($this_location_id==$location_id)
				{
				
				if(isset($item->fields->address_type[0]) && $item->fields->address_type[0] == "physical_address")
					{

					$address['address_1'] = $item->fields->address_1;
					$address['city'] = $item->fields->city;
					$address['state_province'] = $item->fields->state_province;
					$address['postal_code'] = $item->fields->postal_code;
					array_push($location['physical_address'],$address);
					}
				else
					{
					$address['address_1'] = $item->fields->address_1;
					$address['city'] = $item->fields->city;
					$address['state_province'] = $item->fields->state_province;
					$address['postal_code'] = $item->fields->postal_code;
					array_push($location['postal_address'],$address);
					}
				}
			}
		}		
	}	
	?>