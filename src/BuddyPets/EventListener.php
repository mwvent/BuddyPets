<?php

namespace BuddyPets;
use BuddyPets\Entities\Pets;

use pocketmine\event\Listener;

use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\player\PlayerRespawnEvent;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use pocketmine\Server;


class EventListener extends PluginBase implements Listener {
	public $plugin;
	private $pets;
	
	public function __construct(Main $plugin) {
	    $this->plugin = $plugin;
		$this->pets = new \BuddyPets\Entities\Pets($plugin);
	}
	
	public function onPlayerJoin(PlayerJoinEvent $event) {
		$player = $event->getPlayer();
		if ( $player instanceof Player) {
			$this->plugin->petOwnerRegister($player, $event->getPlayer()->getPosition()->getLevel()->getName());
		}
	}
	
	public function onPlayerQuit(PlayerQuitEvent $event) {
	    $player = $event->getPlayer();
		if ( $player instanceof Player) {
			$this->plugin->petOwnerDeregister($event->getPlayer());
		}
	}

	public function onPlayerRespawn(PlayerRespawnEvent $event) {
		$player = $event->getPlayer();
		if ( $player instanceof Player) {
			$this->plugin->petOwnerRegister($player, $event->getRespawnPosition()->getLevel()->getName());
		}
	}
	
	public function onPlayerTeleport(EntityTeleportEvent $event) {
		$player = $event->getEntity();
		if ( $player instanceof Player) {
			$this->plugin->petOwnerRegister($player, $event->getTo()->getLevel()->getName());
		}
	}
}
