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
			case "spawn" :
				if( ! $sender instanceof Player) {
					$sender->sendMessage($this->plugin->translateColors("&", "&cThis command can only be used in-game"));
					return;
				}
				
				if( ! array_key_exists (strtolower($sender->getName()), $this->plugin->petOwners ) ) {
					$sender->sendMessage($this->plugin->translateColors("&", "&cYou are not in a pet enabled world"));
					return;
				}
				
				if( ! $this->plugin->petOwners[ strtolower($sender->getName()) ]->spawnPet() ) {
					$errMsg = $plugin->petOwners[ strtolower($sender->getName()) ]->spawnFailReason;
					$sender->sendMessage($this->plugin->translateColors("&", "&c" . $errMsg));
					return;
				}
				break;
		}
    }
}
