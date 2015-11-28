<?php
namespace BuddyPets\Database;

use BuddyPets\Entities\Pets;

class PetProperties {
	public $petName;
	public $petTypeUID;
	public $expiryTime;
	
	public function __construct($petName, $petTypeUID, $expiryTime) {
		$this->petName = $petName;
		$this->petTypeUID = $petTypeUID;
		$this->expiryTime = $expiryTime;
	}
}