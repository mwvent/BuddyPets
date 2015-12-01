<?php
namespace BuddyPets\Database;

use BuddyPets\Entities\Pets;

class PetProperties {
	public $petName;
	public $petTypeUID;
	public $isActivated;
	public $petIsBaby;
	
	public function __construct($petName, $petTypeUID, $petIsBaby, $isActivated) {
		$this->petName = $petName;
		$this->petTypeUID = $petTypeUID;
		$this->isActivated = $isActivated;
		$this->petIsBaby = $petIsBaby;
	}
}