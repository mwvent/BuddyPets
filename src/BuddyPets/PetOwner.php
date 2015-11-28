<?php

namespace BuddyPets;
use BuddyPets\EventListener;
use BuddyPets\Entities\Pets;
use BuddyPets\Entities\Pet;
use BuddyPets\Database\PetProperties;
use BuddyPets\Entities\DummyChunk;

use pocketmine\nbt\tag\Compound;
use pocketmine\Player;
use pocketmine\entity\Entity;

class PetOwner {
		public $player;
		public $playerName;
		public $playerName_lower;
		public $pet_is_active = false;
		public $petEntity = null;
		public $petProperties = null;
		public $petType;
		public $db;
		public $website;
		
		public $spawnFailReason = "";
		
		public function __construct($player, $db, $website) {
			$this->db = $db;
			$this->player = $player;
			$this->playerName = $player->getName();
			$this->playerName_lower = strtolower($player->getName());
			$this->reload();	
		}
		
		function __destruct() {
			if( isset( $this->petEntity ) ) {
				$this->petEntity->close();
			}
		}
		
		public function reload() {
			$newPetProperties = $this->db->getPetProperties($this);
			if( is_null($newPetProperties) ) {
				$this->petProperties = null;
				$this->petType = null;
				return;
			}
			$this->petProperties = $newPetProperties;
			$this->petType = Pets::getPetType($newPetProperties->petTypeUID);
		}
		
		public function spawnPet() {
			$this->reload();
			if( is_null( $this->petProperties ) ) {
				$spawnFailReason = "You have no pet set - login to $website to create or set a pet.";
				return false;
			}
			
			if( is_null( $this->petType ) ) {
				$spawnFailReason = "Invalid pet type - please login to $website and check you pet settings.";
				return false;
			}
			
			/*
			if( $this->petProperties->expiryTime < currenttime ) {
				$spawnFailReason = "Your pet activiation has expired - please login to $website to activate your pet.";
				return false;
			}
			*/
			
			if(isset($this->petEntity)) {
				if( !$this->petEntity->closed) {
					$this->petEntity->close();
				}
			}
			
			$this->petEntity = new \BuddyPets\Entities\Pet(new dummyChunk, new Compound, $this);

			return true;
		}
}