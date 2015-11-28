<?php
namespace BuddyPets\Entities;

class PetType {
	public $petTypeNID;
	public $petTypeUID;
	public $meta;
	public $name;
	
	public function __construct($petTypeNID, $petTypeUID, $name, $meta = null) {
		$this->NID = $petTypeNID;
		$this->UID = $petTypeUID;
		$this->name = $name;
		$this->meta = is_null($meta) ? [] : $meta;
	}
}