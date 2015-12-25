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
                                        "/pet stay - ask your pet to stay",
                                        "/pet follow - your pet follows you again",
					" ",
					"Setup and activate your pet at ",
					$this->plugin->website
				];
				foreach( $helplines as $helpline ) {
					$sender->sendMessage($this->plugin->translateColors("&",$helpline));
				}
				break;
                        case "stay" :
                                if( ! $sender instanceof Player) {
					$sender->sendMessage($this->plugin->translateColors("&", "&cThis command can only be used in-game"));
					return;
				}
				
				if( array_key_exists (strtolower($sender->getName()), $this->plugin->petOwners ) ) {
					if( ! $this->plugin->petOwners[ strtolower($sender->getName()) ]->petStay()) {
                                            $sender->sendMessage($this->plugin->translateColors("&", "&cCould not command pet, is your pet spawned?"));
                                        } else {
                                            $sender->sendMessage($this->plugin->translateColors("&", "&f* You tell your pet to stay put."));
                                        }
				}
                                break;
                        case "follow" :
                                if( ! $sender instanceof Player) {
					$sender->sendMessage($this->plugin->translateColors("&", "&cThis command can only be used in-game"));
					return;
				}
				
				if( array_key_exists (strtolower($sender->getName()), $this->plugin->petOwners ) ) {
					if( ! $this->plugin->petOwners[ strtolower($sender->getName()) ]->petFollow()) {
                                            $sender->sendMessage($this->plugin->translateColors("&", "&cCould not command pet, is your pet spawned?"));
                                        } else {
                                            $sender->sendMessage($this->plugin->translateColors("&", "&f* You tell your pet to follow."));
                                        }
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
