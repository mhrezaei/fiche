<?php
namespace App\Traits;

trait EhdaPostTrait
{

	public static function getAllEvents($domain = 'auto')
	{
		return self::selector([
			'type' => "event" ,
		     'domain' => $domain ,
		])->orderBy('published_at' , 'desc')->get() ;
	}

	public static function activeEventsArray()
	{
		$events     = [];
		foreach(self::getAllEvents() as $event) {
			if($event->spreadMeta()->can_register_card) {
				$events[] = $event;
			}
		}

		return $events ;

	}

}