<?php
// require php classes to enter seed data
require_once("../classes/venue.php");
require_once("../classes/event-category.php");
require_once("../classes/event.php");

// require mysqli
require_once("/etc/apache2/capstone-mysql/rgevents.php");

$mysqli = MysqliConfiguration::getMysqli();

		// assign Venue objects to array of venues
		$venues[0]	=	new	Venue(null,"The Kimo Theatre",250,"505-505-1001","http://www.kimotheatre.com","12345 Central Ave NE",null,"Albuquerque","NM","87109");
		$venues[1]	=	new	Venue(null,"The Sunshine Theatre",400,"505-582-1000","http://www.sunshinetheatre.com","4325 Central Ave NE",null,"Albuquerque","NM","87110");
		$venues[2]	=	new	Venue(null,"Anodyne",100,"505-382-5000","http://www.anodynebar.com","876 Central Ave NE",null,"Albuquerque","NM","87107");

		// assign EventCategory objects to array of eventCategories
		$parentCategories[0]	=	new	EventCategory(null,"Music",null);
		$parentCategories[1]	=	new	EventCategory(null,"Arts & Theatre",null);
		$parentCategories[2]	=	new	EventCategory(null,"Sports",null);
		$parentCategories[3]	=	new	EventCategory(null,"Family",null);
		$parentCategories[4]	=	new	EventCategory(null,"Miscellaneous",null);


		
try {
	foreach($venues as $venue) {
		$venue->insert($mysqli);
	}

	foreach($parentCategories as $parentCategory) {
		$parentCategory->insert($mysqli);
	}

	$eventCategories[0]	=	new	EventCategory(null,"Rock",$parentCategories[0]->getEventCategoryId());
	$eventCategories[1]	=	new	EventCategory(null,"Folk-Dubstep",$parentCategories[0]->getEventCategoryId());
	$eventCategories[2]	=	new	EventCategory(null,"Country",$parentCategories[0]->getEventCategoryId());
	$eventCategories[3]	=	new	EventCategory(null,"Electronic",$parentCategories[0]->getEventCategoryId());
	$eventCategories[4]	=	new	EventCategory(null,"Comedy",$parentCategories[1]->getEventCategoryId());
	$eventCategories[5]	=	new	EventCategory(null,"Musical",$parentCategories[1]->getEventCategoryId());
	$eventCategories[6]	=	new	EventCategory(null,"Orchestra",$parentCategories[1]->getEventCategoryId());
	$eventCategories[7]	=	new	EventCategory(null,"Art Show",$parentCategories[1]->getEventCategoryId());
	$eventCategories[8]	=	new	EventCategory(null,"College",$parentCategories[2]->getEventCategoryId());
	$eventCategories[9]	=	new	EventCategory(null,"MMA",$parentCategories[2]->getEventCategoryId());
	$eventCategories[10]	=	new	EventCategory(null,"High School",$parentCategories[2]->getEventCategoryId());
	$eventCategories[11]	=	new	EventCategory(null,"Circus",$parentCategories[3]->getEventCategoryId());
	$eventCategories[12]	=	new	EventCategory(null,"Magic Show",$parentCategories[3]->getEventCategoryId());
	$eventCategories[13]	=	new	EventCategory(null,"Expo/Convention",$parentCategories[4]->getEventCategoryId());
	$eventCategories[14]	=	new	EventCategory(null,"Lecture/Seminar",$parentCategories[4]->getEventCategoryId());



	foreach($eventCategories as $eventCategory) {
		$eventCategory->insert($mysqli);
	}

	$events[]		=	new	Event(NULL, $eventCategories[0]->getEventCategoryId(), $venues[1]->getVenueId(), "The Van's Warped Tour", "2015-01-14 17:00:00", 35.00);
	$events[]		=	new	Event(NULL, $eventCategories[0]->getEventCategoryId(), $venues[1]->getVenueId(), "Less Than Jake", "2014-12-28 19:00:00", 20.00);
	$events[]		=	new	Event(NULL, $eventCategories[0]->getEventCategoryId(), $venues[1]->getVenueId(), "The Foo Fighters", "2015-01-08 19:00:00", 45.00);
	$events[]		=	new	Event(NULL, $eventCategories[4]->getEventCategoryId(), $venues[1]->getVenueId(), "Ray Ramano", "2015-01-09 19:30:00", 40.00);
	$events[]		=	new	Event(NULL, $eventCategories[4]->getEventCategoryId(), $venues[1]->getVenueId(), "Kevin Hart: I'm A Grown Little Man", "2014-12-19 20:00:00", 30.00);
	$events[]		=	new	Event(NULL, $eventCategories[4]->getEventCategoryId(), $venues[1]->getVenueId(), "Kevin Hart: I'm A Grown Little Man", "2014-12-20 20:00:00", 40.00);
	$events[]		=	new	Event(NULL, $eventCategories[9]->getEventCategoryId(), $venues[2]->getVenueId(), "UFC 192: Johnson vs Hendricks", "2015-02-08 20:00:00", 75.00);
	$events[]		=	new	Event(NULL, $eventCategories[5]->getEventCategoryId(), $venues[0]->getVenueId(), "The Nutcracker Ballet", "2014-12-12 19:00:00", 28.00);
	$events[]		=	new	Event(NULL, $eventCategories[5]->getEventCategoryId(), $venues[0]->getVenueId(), "The Nutcracker Ballet", "2014-12-13 14:00:00", 22.00);
	$events[]		=	new	Event(NULL, $eventCategories[5]->getEventCategoryId(), $venues[0]->getVenueId(), "The Nutcracker Ballet", "2014-12-13 19:00:00", 28.00);
	$events[]		=	new	Event(NULL, $eventCategories[5]->getEventCategoryId(), $venues[0]->getVenueId(), "The Nutcracker Ballet", "2014-12-19 14:00:00", 22.00);
	$events[]		=	new	Event(NULL, $eventCategories[5]->getEventCategoryId(), $venues[0]->getVenueId(), "The Nutcracker Ballet", "2014-12-19 19:00:00", 28.00);
	$events[]		=	new	Event(NULL, $eventCategories[1]->getEventCategoryId(), $venues[2]->getVenueId(), "Folk-Dubstep 4 Life", "2015-01-22 20:00:00", 19.00);
	$events[]		=	new	Event(NULL, $eventCategories[5]->getEventCategoryId(), $venues[0]->getVenueId(), "A Christmas Carol", "2015-12-09 19:00:00", 22.00);
	$events[]		=	new	Event(NULL, $eventCategories[5]->getEventCategoryId(), $venues[0]->getVenueId(), "A Christmas Carol", "2015-12-10 19:00:00", 22.00);
	$events[]		=	new	Event(NULL, $eventCategories[5]->getEventCategoryId(), $venues[0]->getVenueId(), "A Christmas Carol", "2015-12-11 19:00:00", 22.00);
	$events[]		=	new	Event(NULL, $eventCategories[5]->getEventCategoryId(), $venues[0]->getVenueId(), "A Christmas Carol", "2015-12-12 14:00:00", 17.00);
	$events[]		=	new	Event(NULL, $eventCategories[5]->getEventCategoryId(), $venues[0]->getVenueId(), "A Christmas Carol", "2015-12-12 19:00:00", 22.00);
	$events[]		=	new	Event(NULL, $eventCategories[5]->getEventCategoryId(), $venues[0]->getVenueId(), "A Christmas Carol", "2015-12-12 19:00:00", 22.00);
	$events[]		=	new	Event(NULL, $eventCategories[1]->getEventCategoryId(), $venues[1]->getVenueId(), "DJ Lucky#Slevin", "2015-01-28 20:00:00", 18.00);
	$events[]		=	new	Event(NULL, $eventCategories[7]->getEventCategoryId(), $venues[2]->getVenueId(), "Metric", "2014-12-13 20:00:00", 35.00);
	$events[]		=	new	Event(NULL, $eventCategories[7]->getEventCategoryId(), $venues[2]->getVenueId(), "The Godfather: Part I", "2015-01-09 19:00:00", 12.00);
	$events[]		=	new	Event(NULL, $eventCategories[7]->getEventCategoryId(), $venues[2]->getVenueId(), "The Godfather: Part II", "2015-01-10 19:00:00", 12.00);

	foreach($events as $event)	{
		$event->insert($mysqli);
	}
} catch(Exception $exception) {
	echo $exception->getMessage();
}