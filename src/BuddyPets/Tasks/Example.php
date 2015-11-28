<?php
namespace BuddyChannels\Tasks;
use pocketmine\scheduler\Task;
use BuddyChannels\Main;
use BuddyChannels\Database;
use pocketmine\Player;
use pocketmine\Server;

class SetUserBlockTask extends Task {
    private $plugin;
    private $database;
    private $player;
    private $username;
    private $username_lcase;
    private $targetplayer;
    private $targetplayer_name;
    private $targetplayer_lcase_name;
    private $is_blocking;
    
    public function __construct(
				  \BuddyChannels\Main $plugin, 
				  \pocketmine\Player $player, 
				  $targetplayer_name, // set to null if using $targetplayer
				  $is_blocking,
				  \pocketmine\Player $targetplayer = null) {
	$this->plugin=$plugin;
	$this->database = $plugin->database;
	
	$this->player = $player;
	$this->username = $player->getName();
	$this->username_lcase = strtolower($this->username);
	
	if( is_null ( $targetplayer ) ) {
	    $this->targetplayer = null;
	    $this->targetplayer_name = $targetplayer_name;
	} else {
	    $this->targetplayer = $targetplayer;
	    $this->targetplayer_name = $targetplayer->getName();
	}
	$this->targetplayer_lcase_name = strtolower($this->targetplayer_name);
	
	$this->is_blocking = $is_blocking;
	
	$plugin->getServer()->getScheduler()->scheduleTask($this);
    }
    
    public function onRun($currenttick) {
	if( $this->is_blocking ) {
	    if( $this->database->db_addUserMetaData($this->username_lcase, "blocked", $this->targetplayer_lcase_name) ) {
		$returnmsg = "&dYou have &cblocked &dplayer &b" . $this->targetplayer_name;
		$targetsmsg = "&dYou have been &cblocked &dby &b" . $this->username;
	    } else {
		$returnmsg = "&cSomething went wrong blocking " . $this->targetplayer_name;
	    }
	} else {
	    if( $this->database->db_removeUserMetaData($this->username_lcase, "blocked", $this->targetplayer_lcase_name) ) {
		$returnmsg = "&dYou have &aunblocked &dplayer &b" . $this->targetplayer_name;
		$targetsmsg = "&dYou have been &aunblocked &dby &b" . $this->username;
	    } else {
		$returnmsg = "&cSomething went wrong unblocking " . $this->targetplayer_name;
	    }
	}
	
	if( isset($returnmsg) ) {
	    $this->player->sendMessage(Main::translateColors("&", $returnmsg));
	}
	
	if( isset($targetsmsg) && !is_null($this->targetplayer) ) {
	    $this->targetplayer->sendMessage(Main::translateColors("&", $targetsmsg));
	}
    }
}