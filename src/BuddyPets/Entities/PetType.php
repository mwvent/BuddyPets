<?php
namespace BuddyPets\Entities;

class PetType {
	public $meta;
	public $name;
	public $NID;
	public $UID;
	
	public function __construct($petTypeNID, $petTypeUID, $name, $meta = null) {
		$this->NID = $petTypeNID;
		$this->UID = $petTypeUID;
		$this->name = $name;
		$this->meta = is_null($meta) ? [] : $meta;
	}
}