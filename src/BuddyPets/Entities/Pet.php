<?php
namespace BuddyPets\Entities;
use BuddyPets\Entities\DummyChunk;
use BuddyPets\Entities\PetType;
use BuddyPets\Entities\Pets;
use BuddyPets\PetOwner;
use BuddyPets\Main;

use pocketmine\item\Item;
use pocketmine\network\protocol\AddMobPacket;
use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\network\Network;
use pocketmine\Player;
use pocketmine\entity\Animal;
use pocketmine\entity\Entity;
use pocketmine\entity\Tameable;
use pocketmine\math\AxisAlignedBB;
use pocketmine\network\protocol\MovePlayerPacket;
use pocketmine\utils\TextFormat;


use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\network\protocol\EntityEventPacket;

use pocketmine\level\format\FullChunk;
use pocketmine\level\Location;
use pocketmine\level\Position;
use pocketmine\nbt\tag\Byte;
use pocketmine\nbt\tag\Compound;
use pocketmine\nbt\tag\Double;
use pocketmine\nbt\tag\Enum;
use pocketmine\nbt\tag\Float;
use pocketmine\nbt\tag\Short;
use pocketmine\nbt\tag\String;
use pocketmine\permission\PermissibleBase;
use pocketmine\permission\PermissionAttachment;
use pocketmine\plugin\Plugin;

/*
public function spawnNewPet($player, $petName, $pettype_uid) {
		echo "DBG: $pettype_uid \n";

	}
*/

class Pet extends Animal implements Tameable{
	// const NETWORK_ID=14;
	// const NETWORK_ID=10;
	public static $speed = 0.2;
	public static $jump = 4;
	public static $dist = 2;
	public $width = 0.625;
	public $length = 1.4375;
	public $height = 1.25;
	public $owner = null;
	public $knockback = 0;
	
	private $petOwner;
	private $petName;
	private $petName_unformatted;
	private $targetPlayer;
	
	public function getName(){
		return $this->petName;
	}
	
	public function isNameTagVisible() {
		return true;
	}
	
	public function getNameTag() {
		return $this->petName;
	}
	
	public function __construct(
		FullChunk $chunk, Compound $nbt, PetOwner $petOwner ) {
		// if $petOwner is null pocketmine is probably trying to reload a saved
		// version of this entity which we do not want anymore - as it is not cancellable ( I think ? )
		// just let it create and the update function will despawn the entity immediatley when it finds
		// it to have no targetPlayer
		if( is_null ($petOwner) ) {
		    parent::__construct($chunk, $nbt);
		    $this->close();
		    return;
		} 
		
		// TODO Catch error
		$this->petOwner = $petOwner;
		$this->petName_unformatted = $petOwner->petProperties->petName;
		$this->ownerName = $this->petOwner->player->getName();
		$this->petName = Main::translateColors("&", "&c[" . $this->ownerName . "] &f" . $this->petName_unformatted);
		$this->petType =  $petOwner->petType;
		
		$location = $this->petOwner->player->getLocation();
		$nbt =  new Compound("",[
			new Enum("Pos",[
				new Double("",$location->x),
				new Double("",$location->y),
				new Double("",$location->z),
				]),
			new Enum("Motion", [
				new Double("",0),
				new Double("",0),
				new Double("",0),
				]),
			new Enum("Rotation",[
				new Float("",$location->yaw),
				new Float("",$location->pitch),
				]),
			]);
			
		$nbt->CustomName = new String("CustomName", $this->petName);
		$nbt->CustomNameVisible = new Byte("CustomNameVisible", 1);
		
		$chunk = $location->getLevel()->getChunk($location->x >> 4, $location->z >> 4);
		$this->setNameTagVisible(true);
		
		parent::__construct($chunk, $nbt);
		
		$this->setNameTagVisible(true);
		$this->dataProperties = array_replace($this->dataProperties, $this->petType->meta);
		
		$this->spawnToAll();
		
		return true;
	}
	
	// 'disabled' entity functions
	public function saveNBT(){
		return null;
	}
	
	public function attack($damage, EntityDamageEvent $source){
		/*
		$attacker = $source->getDamager();
		if($source instanceof EntityDamageByChildEntityEvent){
		    $attacker = $source->getDamager();
		}
	    if($attacker instanceof Player || get_class($attacker) == "pocketmine\Player") {
			// $attacker->sendMessage("Hello");
	    }
		*/
    }
	
	public function spawnTo(Player $player){
		$pk = new AddEntityPacket();
		$pk->eid = $this->getId();
		// $pk->type = self::NETWORK_ID;
		$pk->type = $this->petType->NID;
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->speedX = $this->motionX;
		$pk->speedY = $this->motionY;
		$pk->speedZ = $this->motionZ;
		$pk->yaw = $this->yaw;
		$pk->pitch = $this->pitch;
		$pk->metadata = $this->dataProperties;
		$player->dataPacket($pk->setChannel(Network::CHANNEL_ENTITY_SPAWNING));
		parent::spawnTo($player);
	}
	public function getDrops(){
		return [];
	}
	public function getBoundingBox(){
		$this->boundingBox = new AxisAlignedBB(
			$x = $this->x - $this->width / 2,
			$y = $this->y - $this->height / 2 + $this->stepHeight,
			$z = $this->z - $this->length / 2,
			$x + $this->width,
			$y + $this->height - $this->stepHeight,
			$z + $this->length
		);
		return $this->boundingBox;
	}
	public function noupdateMovement(){
		if($this->x !== $this->lastX or $this->y !== $this->lastY or $this->z !== $this->lastZ or $this->yaw !== $this->lastYaw or $this->pitch !== $this->lastPitch){
			$event = new \pocketmine\event\entity\EntityMoveEvent($this,new \pocketmine\math\Vector3($this->x - $this->lastX,$this->y - $this->lastY,$this->z - $this->lastZ));
			$this->server->getPluginManager()->callEvent($event);
			if ($event->isCancelled()) return;
			$this->lastX = $this->x;
			$this->lastY = $this->y;
			$this->lastZ = $this->z;
			$this->lastYaw = $this->yaw;
			$this->lastPitch = $this->pitch;
			$pk = new MovePlayerPacket();
			$pk->eid = $this->id;
			$pk->x = $this->x;
			$pk->y = $this->y;
			$pk->z = $this->z;
			$pk->yaw = $this->yaw;
			$pk->pitch = $this->pitch;
			$pk->bodyYaw = $this->yaw;
			foreach($this->hasSpawned as $player){
				$player->dataPacket($pk);
			}
		}
		if(($this->lastMotionX != $this->motionX or $this->lastMotionY != $this->motionY or $this->lastMotionZ != $this->motionZ)){
			$this->lastMotionX = $this->motionX;
			$this->lastMotionY = $this->motionY;
			$this->lastMotionZ = $this->motionZ;
			foreach($this->hasSpawned as $player){
				$player->addEntityMotion($this->id, $this->motionX, $this->motionY, $this->motionZ);
			}
		}
	}
	public function onUpdate($currentTick){
		$hasUpdate = false;
		$this->timings->startTiming();
		// Handle flying objects...
		$tickDiff = max(1, $currentTick - $this->lastUpdate);
		$bb = clone $this->getBoundingBox();
		$onGround = count($this->level->getCollisionBlocks($bb->offset(0, -$this->gravity, 0))) > 0;
		if(!$onGround){
			// falling or jumping...
			$this->motionY -= $this->gravity;
			$this->x += $this->motionX * $tickDiff;
			$this->y += $this->motionY * $tickDiff;
			$this->z += $this->motionZ * $tickDiff;
			//echo ("Falling...\n");
		}else{
			$this->motionX = 0; // No longer jumping/falling
			$this->motionY = 0;
			$this->motionZ = 0;
			if ($this->y != floor($this->y)) $this->y = floor($this->y);
			// Try to attack a player
			$target = null;
			if ($this->petOwner->player) {
				$target = $this->petOwner->player;
				if ($target) {
					if ($target->getLevel() != $this->level) {
						// Pet is in a different level...
						$target = null;
					} else {
						$dist = $this->distance($target);
					}
				}
			}
			
			// if no target despawn
			if($target === null){
				$this->close();
				return;
			}
			
			if($target !== null){
				$dir = $target->subtract($this);
				$dir = $dir->divide($dist);
				$this->yaw = rad2deg(atan2(-$dir->getX(),$dir->getZ()));
				$this->pitch = rad2deg(atan(-$dir->getY()));
				if ($dist > self::$dist) {
					//
					$x = $dir->getX() * self::$speed;
					$y = 0;
					$z = $dir->getZ() * self::$speed;
					$isJump = count($this->level->getCollisionBlocks($bb->offset($x, 1.2, $z))) <= 0;
					if(count($this->level->getCollisionBlocks($bb->offset(0, 0.1, $z))) > 0){
						if ($isJump) {
							$y = self::$jump;
							$this->motionZ = $z;
						}
						$z = 0;
					}
					if(count($this->level->getCollisionBlocks($bb->offset($x, 0.1, 0))) > 0){
						if ($isJump) {
							$y = self::$jump;
							$this->motionX = $x;
						}
						$x = 0;
					}
					//if ($y) echo "Jumping\n";
					$ev = new \pocketmine\event\entity\EntityMotionEvent($this,new \pocketmine\math\Vector3($x,$y,$z));
					$this->server->getPluginManager()->callEvent($ev);
					if ($ev->isCancelled()) return false;
					$this->x += $x;
					$this->y += $y;
					$this->z += $z;
				}
				
				if ($dist > 30) {
					$target->sendMessage($this->petName_unformatted . " could not keep up - use /pet spawn again to bring them back");
					$this->close();
				}
			}
		}
		$bb = clone $this->getBoundingBox();
		$onGround = count($this->level->getCollisionBlocks($bb->offset(0, -$this->gravity, 0))) > 0;
		$this->onGround = $onGround;
		$this->timings->stopTiming();
		$hasUpdate = parent::onUpdate($currentTick) || $hasUpdate;
		return $hasUpdate;
	}
	public function knockBack(Entity $attacker, $damage, $x, $z, $base = 0.4){
		return; // no knockBack
	}
}