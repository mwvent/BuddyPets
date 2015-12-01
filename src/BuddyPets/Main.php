<?php

namespace BuddyPets;
use BuddyPets\EventListener;
use BuddyPets\Entities\Pets;
use BuddyPets\Database\Database;

use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\permission\Permission;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use pocketmine\entity\Entity;

class Main extends PluginBase {
    const PRODUCER = "mwvent";
    const VERSION = "1.0";
    const PREFIX = "&b[&aBuddy&ePets&b] ";

	public $db;
    public $cfg;
    public $website;
	public $petOwners = [];
	public $petLevel = "";
	
    public function onEnable() {
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->getCommand("pet")->setExecutor(new Commands\Commands($this));
		$this->website = $this->read_cfg("website");
		$this->petLevel = $this->read_cfg("petworld");
		$this->db = new \BuddyPets\Database\Database($this);
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		Entity::registerEntity(\BuddyPets\Entities\Pets::class,true);
    }
	
	public function petOwnerRegister(Player $player, $levelname) {
		$lcasename = strtolower($player->getName());
		$lcaselevelname = strtolower($levelname);
		$inPetsLevel = (strtolower($this->petLevel) == $lcaselevelname); // TODO $levelname = configlevelname
		$playerRegistered =  isset ( $this->petOwners[$lcasename] );
		// handle pet owner entered pet world (tp/login)
		if($inPetsLevel && !$playerRegistered ) {
			$this->petOwners[$lcasename] = new PetOwner($player, $this->db, $this->website);
			return;
		}
		// handle pet owner stayed in pet world
		if($inPetsLevel) {
			return;
		}
		// handle pet owner left pet world / logged into another world
		$this->petOwnerDeregister($player);
	}
	
	public function petOwnerDeregister(Player $player) {
		$lcasename = strtolower($player->getName());
		$playerRegistered =  isset ( $this->petOwners[$lcasename] );
		if( $playerRegistered ) {
			if( isset($this->petOwners[$lcasename]) ) {
				$this->petOwners[$lcasename]->deSpawnPet();
				unset($this->petOwners[$lcasename]);
			}
		}
	}

    public static function translateColors($symbol, $message) {
		$message = str_replace($symbol."0", TextFormat::BLACK, $message);
		$message = str_replace($symbol."1", TextFormat::DARK_BLUE, $message);
		$message = str_replace($symbol."2", TextFormat::DARK_GREEN, $message);
		$message = str_replace($symbol."3", TextFormat::DARK_AQUA, $message);
		$message = str_replace($symbol."4", TextFormat::DARK_RED, $message);
		$message = str_replace($symbol."5", TextFormat::DARK_PURPLE, $message);
		$message = str_replace($symbol."6", TextFormat::GOLD, $message);
		$message = str_replace($symbol."7", TextFormat::GRAY, $message);
		$message = str_replace($symbol."8", TextFormat::DARK_GRAY, $message);
		$message = str_replace($symbol."9", TextFormat::BLUE, $message);
		$message = str_replace($symbol."a", TextFormat::GREEN, $message);
		$message = str_replace($symbol."b", TextFormat::AQUA, $message);
		$message = str_replace($symbol."c", TextFormat::RED, $message);
		$message = str_replace($symbol."d", TextFormat::LIGHT_PURPLE, $message);
		$message = str_replace($symbol."e", TextFormat::YELLOW, $message);
		$message = str_replace($symbol."f", TextFormat::WHITE, $message);
		$message = str_replace($symbol."k", TextFormat::OBFUSCATED, $message);
		$message = str_replace($symbol."l", TextFormat::BOLD, $message);
		$message = str_replace($symbol."m", TextFormat::STRIKETHROUGH, $message);
		$message = str_replace($symbol."n", TextFormat::UNDERLINE, $message);
		$message = str_replace($symbol."o", TextFormat::ITALIC, $message);
		$message = str_replace($symbol."r", TextFormat::RESET, $message);
		// $message = str_replace(" ", "ᱹ", $message);
		return $message;
    }
    
    public static function removeColors($symbol, $message) {
		$colourCodes = str_split("1234567890abcdefghijklmnopqrstuvwxyz");
		foreach($colourCodes as $key => $code) {
			$message = str_replace($symbol.$code, "", $message);
		}
		return $message;
    }

    public function read_cfg($key, $defaultvalue = null) {
		// if not loaded config load and continue
		if( ! isset($this->cfg) ) {
			$this->cfg = $this->getConfig()->getAll();
		}
		// if key not in config but a default value is allowed return default
		if( ( ! isset($this->cfg[$key]) ) && ( ! is_null( $defaultvalue ) ) ) {
			return $defaultvalue;
		}
		// if key not in config but is required
		if( ( ! isset($this->cfg[$key]) ) && ( ! is_null( $defaultvalue ) ) ) {
			$sendmsg = "Cannot load " . Main::PREFIX . " required config key " . $key . " not found in config file";
			Server::getInstance()->getLogger()->critical($this->translateColors("&", Main::PREFIX . $sendmsg));
			return;
		}
		// otherwise return config file value
		return $this->cfg[$key];
    }
    
    // getplayer & validateName - copied / stole from EssentialsPE, why reinvent the wheel? thanks guys :-)
    public function getPlayer($player){
        if(!$this->validateName($player, false)){
            return false;
        }
        $player = strtolower($player);
        $found = false;
        foreach($this->getServer()->getOnlinePlayers() as $p){
            if(strtolower(TextFormat::clean($p->getDisplayName(), true)) === $player || strtolower($p->getName()) === $player){
                $found = $p;
                break;
            }
        }
        // If cannot get the exact player name/nick, try with portions of it
        if(!$found){
            $found = ($f = $this->getServer()->getPlayer($player)) === null ? false : $f; // PocketMine function to get from portions of name
        }
        /*
         * Copy from PocketMine's function (use above xD) but modified to work with Nicknames :P
         *
         * ALL THE RIGHTS FROM THE FOLLOWING CODE BELONGS TO POCKETMINE-MP
         */
        if(!$found){
            $delta = \PHP_INT_MAX;
            foreach($this->getServer()->getOnlinePlayers() as $p){
                // Clean the Display Name due to colored nicks :S
                if(\stripos(($n = TextFormat::clean($p->getDisplayName(), true)), $player) === 0){
                    $curDelta = \strlen($n) - \strlen($player);
                    if($curDelta < $delta){
                        $found = $p;
                        $delta = $curDelta;
                    }
                    if($curDelta === 0){
                        break;
                    }
                }
            }
        }
        return $found;
    }
    
    public function validateName($string, $allowColorCodes = false) {
        if(trim($string) === ""){
            return false;
        }
        $format = [];
        if($allowColorCodes){
            $format[] = "/(\&|\§)[0-9a-fk-or]/";
        }
        $format[] = "/[a-zA-Z0-9_]/"; // Due to color codes can be allowed, then check for them first, so after, make a normal lookup
        $s = preg_replace($format, "", $string);
        if(strlen($s) !== 0){
            return false;
        }
        return true;
    }
}

