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
			$this->website = $website;
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
		
		function debugSetMeta($petTypeNID, $id, $val) {
			$this->reload();
			$this->petType->NID=$petTypeNID;
			$this->petType->meta[$id]=[0, $val];
			$this->petEntity = new \BuddyPets\Entities\Pet(new dummyChunk, new Compound, $this);
		}
		
		public function reload() {
			if(isset($this->petEntity)) {
				if( !$this->petEntity->closed) {
					$this->petEntity->close();
				}
			}
			$newPetProperties = $this->db->getPetProperties($this);
			if( is_null($newPetProperties) ) {
				$this->petProperties = null;
				$this->petType = null;
				return;
			}
			$this->petProperties = $newPetProperties;
			$this->petType = Pets::getPetType($newPetProperties->petTypeUID, $newPetProperties->petIsBaby);
		}
		
		public function deSpawnPet() {
			if(isset($this->petEntity)) {
				if( !$this->petEntity->closed) {
					$this->petEntity->close();
				}
			}
		}
                
                public function petStay() {
                        if(isset($this->petEntity)) {
				if( !$this->petEntity->closed) {
					return $this->petEntity->stay();
				}
			}
                        return false;
                }
                
                public function petFollow() {
                        if(isset($this->petEntity)) {
				if( !$this->petEntity->closed) {
					return $this->petEntity->follow();
				}
			}
                        return false;
                }
		
		public function spawnPet() {
			$this->reload();
			if( is_null( $this->petProperties ) ) {
				$this->spawnFailReason = $this->db->getLastOwnerError($this);
				return false;
			}
			
			if( is_null( $this->petType ) ) {
				$this->spawnFailReason = "Invalid pet type - please login to $this->website and check your pet settings.";
				return false;
			}
			
			if( ! $this->petProperties->isActivated ) {
				$this->spawnFailReason = "Your pet activiation has expired - please login to $this->website to activate your pet.";
				return false;
			}
			
			if(isset($this->petEntity)) {
				if( !$this->petEntity->closed) {
					$this->petEntity->close();
				}
			}
			
			$this->petEntity = new \BuddyPets\Entities\Pet(new dummyChunk, new Compound, $this);

			return true;
		}
}