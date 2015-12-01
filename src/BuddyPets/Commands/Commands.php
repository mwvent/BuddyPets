<?php

namespace BuddyPets\Commands;
use BuddyPets\Main;

use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\permission\Permission;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Commands extends PluginBase implements CommandExecutor{
	public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) {
		$valid_commands = array("pet");
		if(!in_array($cmd->getName(), $valid_commands)) {
			return;
		}

		// no args help shortcut
		if(!isset($args[0])) {
			$args[0]="help";
		}
		
		// spawn aliases
		
		switch($args[0]) {
			case "help" :
				$helplines = [
					"BuddyPets Commands",
					"------------------",
					"/pet spawn - spawn in your pet",
					"/pet despawn - despawn your pet",
					" ",
					"Setup and activate your pet at ",
					$plugin->website
				];
				foreach( $helplines as $helpline ) {
					$sender->sendMessage($this->plugin->translateColors("&",$helpline));
				}
				break;
			case "despawn" :
				if( ! $sender instanceof Player) {
					$sender->sendMessage($this->plugin->translateColors("&", "&cThis command can only be used in-game"));
					return;
				}
				
				if( array_key_exists (strtolower($sender->getName()), $this->plugin->petOwners ) ) {
					$this->plugin->petOwners[ strtolower($sender->getName()) ]->deSpawnPet();
					return;
				}
			case "spawn" :
				if( ! $sender instanceof Player) {
					$sender->sendMessage($this->plugin->translateColors("&", "&cThis command can only be used in-game"));
					return;
				}
				
				if( ! array_key_exists (strtolower($sender->getName()), $this->plugin->petOwners ) ) {
					$sender->sendMessage($this->plugin->translateColors("&", "&cYou can only spawn pets in " . $this->plugin->petLevel));
					return;
				}
				
				/*
				if ( isset($args[1]) && isset($args[2])  && isset($args[3]) ) {
					$this->plugin->petOwners[ strtolower($sender->getName()) ]->debugSetMeta($args[1], $args[2], $args[3]);
					return;
				}
				*/
				
				if( ! $this->plugin->petOwners[ strtolower($sender->getName()) ]->spawnPet() ) {
					$errMsg = $this->plugin->petOwners[ strtolower($sender->getName()) ]->spawnFailReason;
					$sender->sendMessage($this->plugin->translateColors("&", "&c" . $errMsg));
					return;
				}
				break;
		}
    }
}
