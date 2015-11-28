<?php
namespace BuddyPets\Database;
use BuddyPets\Entities\Pets;
use BuddyPets\Database\PetProperties;
use BuddyPets\PetOwner;

class Database {
	private $lastOwnerError = [];
	
	public function getPetProperties(PetOwner $petOwner) {
		$test = New PetProperties("Voxel", Pets::RABBIT_SPOTTED, 0);
		return $test;
	}
	
	public function getLastOwnerError(PetOwner $petOwner) {
		if( isset( $this->lastOwnerError[ $petOwner->playerName_lower ] ) ) {
			return $this->lastOwnerError[ $petOwner->playerName_lower ];
		}
		return "Unknown error";
	}
}