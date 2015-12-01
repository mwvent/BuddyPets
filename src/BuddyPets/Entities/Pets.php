<?php
namespace BuddyPets\Entities;
use BuddyPets\Entities\PetType;

class Pets {
	const ZOMBIE = 32;
	const CREEPER = 33;
	const SKELTON = 34;
	const SPIDER = 35;
	const ZOMBIE_PIGMAN = 36;
	const SLIME = 37;
	const ENDERMAN = 38;
	const SILVERFISH = 39;
	const CAVE_SPIDER = 40;
	const GHAST = 41;
	const MAGMA_CUBE = 42;
	const BLAZE = 43;
	const ZOMBIE_VILLAGER = 44;
	const CHICKEN = 10;
	const COW = 11;
	const PIG = 12;
	const MOOSHROOM = 16;
	const SQUID = 17;
	
	const BAT = 19;
	const IRON_GOLEM = 20;
	const SNOW_GOLEM = 21;
	
	const CAT = 22;
	const CAT_TYPE_INDEX = 18;
	const CAT_WILD = 2200;
	const CAT_TUXEDO = 2201;
	const CAT_TABBY = 2202;
	const CAT_SIAMESE = 2203;
	
	const RABBIT = 18;
	const RABBIT_TYPE_INDEX = 18;
	const RABBIT_BROWN = 1800;
	const RABBIT_BLACK = 1801;
	const RABBIT_ALBINO = 1802;
	const RABBIT_SPOTTED = 1803;
	const RABBIT_SALT_AND_PEPPER = 1804;
	const RABBIT_GOLDEN = 1805;
	
	const WOLF = 14;
	const WOLF_TAME_INDEX = 17;
	const WOLF_TAME_BIT = 0x04;
	const WOLF_COLLAR_INDEX = 20;
	const WOLF_EVIL = 1417;
	const WOLF_WILD = 1416;
	const WOLF_BLACK = 1415;
	const WOLF_RED = 1414;
	const WOLF_GREEN = 1413;
	const WOLF_COCOA = 1412;
	const WOLF_LAPIS = 1411;
	const WOLF_PURPLE = 1410;
	const WOLF_CYAN = 1409;
	const WOLF_LIGHT_GREY = 1408;
	const WOLF_GREY = 1407;
	const WOLF_PINK = 1406;
	const WOLF_LIME = 1405;
	const WOLF_YELLOW = 1404;
	const WOLF_LIGHT_BLUE = 1403;
	const WOLF_MAGENTA = 1402;
	const WOLF_ORANGE = 1401;
	const WOLF_WHITE = 1400;
	
	const SHEEP = 13;
	const SHEEP_WHITE = 1300;
	const SHEEP_ORANGE = 1301;
	const SHEEP_MAGENTA = 1302;
	const SHEEP_LIGHT_BLUE = 1303;
	const SHEEP_YELLOW = 1304;
	const SHEEP_LIME = 1305;
	const SHEEP_PINK = 1306;
	const SHEEP_GREY = 1307;
	const SHEEP_LIGHT_GREY = 1308;
	const SHEEP_CYAN = 1309;
	const SHEEP_PURPLE = 1310;
	const SHEEP_LAPIS = 1311;
	const SHEEP_COCOA = 1312;
	const SHEEP_GREEN = 1313;
	const SHEEP_RED = 1314;
	const SHEEP_BLACK = 1315;
	const SHEEP_COLOUR_INDEX = 16;
	
	const PETDATA_UID = 1;
	const PETDATA_NETWORK_ID = 2;
	const PETDATA_NAME = 3;
	const PETDATA_METADATA =4;

	const DATATYPE_BYTE = 0;
	
	public static function meta_baby() {
		return [ 14 => [ Pets::DATATYPE_BYTE, 1 ] ];
	}
	
	public static function meta_tame() {
		return [Pets::WOLF_TAME_INDEX => [Pets::DATATYPE_BYTE, Pets::WOLF_TAME_BIT]];
	}
	
	public static function meta_sheep_colour($colour) {
		return [Pets::SHEEP_COLOUR_INDEX => [ Pets::DATATYPE_BYTE, $colour ]];
	}
	
	public static function meta_wolf_colour($colour) {
		return [Pets::WOLF_COLLAR_INDEX => [ Pets::DATATYPE_BYTE, $colour ]];
	}
	
	public static function meta_wolf_evil() {
		return [14 => [ Pets::DATATYPE_BYTE, 04 ]];
	}
	
	public static function meta_rabbit_type($type) { // 0-5
		return [Pets::RABBIT_TYPE_INDEX => [Pets::DATATYPE_BYTE, $type]];
	}
	
	public static function meta_cat_type($type) { // 0-3
		return [Pets::CAT_TYPE_INDEX => [Pets::DATATYPE_BYTE, $type]];
	}
	
	public static function getPetType($uid, $isBaby = false) {
		$nid = null;
		$name = null;
		$meta = [];
		
		if($isBaby) {
			 $meta = array_replace($meta, Pets::meta_baby());
		}
		
		switch($uid) {
			// Simple
			case Pets::MOOSHROOM :
				return new PetType($uid, $uid, "MOOSHROOM", $meta);
				break;
			case Pets::SHEEP :
				return new PetType($uid, $uid, "SHEEP", $meta);
				break;
			case Pets::PIG :
				return new PetType($uid, $uid, "PIG", $meta);
				break;
			case Pets::COW :
				return new PetType($uid, $uid, "COW", $meta);
				break;
			case Pets::CHICKEN :
				return new PetType($uid, $uid, "CHICKEN", $meta);
				break;
			case Pets::BLAZE :
				return new PetType($uid, $uid, "BLAZE", $meta);
				break;
			case Pets::MAGMA_CUBE :
				return new PetType($uid, $uid, "MAGMA_CUBE", $meta);
				break;
			case Pets::CAVE_SPIDER :
				return new PetType($uid, $uid, "CAVE_SPIDER", $meta);
				break;
			case Pets::ENDERMAN :
				return new PetType($uid, $uid, "ENDERMAN", $meta);
				break;
			case Pets::SLIME :
				return new PetType($uid, $uid, "SLIME", $meta);
				break;
			case Pets::SPIDER :
				return new PetType($uid, $uid, "SPIDER", $meta);
				break;
			case Pets::SKELTON :
				return new PetType($uid, $uid, "SKELTON", $meta);
				break;
			case Pets::ZOMBIE :
				return new PetType($uid, $uid, "ZOMBIE", $meta);
				break;
			case Pets::CREEPER :
				return new PetType($uid, $uid, "CREEPER", $meta);
				break;
			case Pets::RABBIT_BROWN : 
				$name = "Brown Rabbit";
				$meta = array_replace($meta, Pets::meta_rabbit_type(0));
				$nid = Pets::RABBIT;
				break;
			case Pets::RABBIT_BLACK :
				$name = "Black Rabbit";
				$meta = array_replace($meta, Pets::meta_rabbit_type(1));
				$nid = Pets::RABBIT;
				break;
			case Pets::RABBIT_ALBINO :
				$name = "Albino Rabbit";
				$meta = array_replace($meta, Pets::meta_rabbit_type(2));
				$nid = Pets::RABBIT;
				break;
			case Pets::RABBIT_SPOTTED :
				$name = "Spotted Rabbit";
				$meta = array_replace($meta, Pets::meta_rabbit_type(3));
				$nid = Pets::RABBIT;
				break;
			case Pets::RABBIT_SALT_AND_PEPPER :
				$name = "SalntNPepper Rabbit";
				$meta = array_replace($meta, Pets::meta_rabbit_type(4));
				$nid = Pets::RABBIT;
				break;
			case Pets::RABBIT_GOLDEN :
				$name = "Golden Rabbit";
				$meta = array_replace($meta, Pets::meta_rabbit_type(5));
				$nid = Pets::RABBIT;
				break;
			case Pets::CAT_WILD :
				$name = "Wild Cat";
				$meta = array_replace($meta, Pets::meta_cat_type(0));
				$nid = Pets::CAT;
				break;
			case Pets::CAT_TUXEDO :
				$name = "Tuxedo Cat";
				$meta = array_replace($meta, Pets::meta_cat_type(1));
				$nid = Pets::CAT;
				break;
			case Pets::CAT_TABBY : 
				$name = "Tabby Cat";
				$meta = array_replace($meta, Pets::meta_cat_type(2));
				$nid = Pets::CAT;
				break;
			case Pets::CAT_SIAMESE :
				$name = "Siamese Cat";
				$meta = array_replace($meta, Pets::meta_cat_type(3));
				$nid = Pets::CAT;
				break;
			case Pets::WOLF_WILD :
				$name = "Wolf";
				$meta = array_replace($meta, Pets::meta_wolf_colour(0));
				$nid = Pets::WOLF;
				break;
			case Pets::WOLF_BLACK : 
				$name = "Dog (Black Collar)";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_wolf_colour(15));
				$nid = Pets::WOLF;
				break;
			case Pets::WOLF_RED :
				$name = "Dog (Red Collar)";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_wolf_colour(14));
				$nid = Pets::WOLF;
				break;
			case Pets::WOLF_GREEN :
				$name = "Dog (Green Collar)";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_wolf_colour(13));
				$nid = Pets::WOLF;
				break;
			case Pets::WOLF_COCOA :
				$name = "Dog (Cocoa Collar)";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_wolf_colour(12));
				$nid = Pets::WOLF;
				break;
			case Pets::WOLF_LAPIS : 
				$name = "Dog (Lapis Collar)";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_wolf_colour(11));
				$nid = Pets::WOLF;
				break;
			case Pets::WOLF_PURPLE :
				$name = "Dog (Purple Collar)";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_wolf_colour(10));
				$nid = Pets::WOLF;
				break;
			case Pets::WOLF_CYAN : 
				$name = "Dog (Cyan Collar)";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_wolf_colour(9));
				$nid = Pets::WOLF;
				break;
			case Pets::WOLF_LIGHT_GREY :
				$name = "Dog (Light Grey Collar)";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_wolf_colour(8));
				$nid = Pets::WOLF;
				break;
			case Pets::WOLF_GREY :
				$name = "Dog (Grey Collar)";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_wolf_colour(7));
				$nid = Pets::WOLF;
				break;
			case Pets::WOLF_PINK : 
				$name = "Dog (Pink Collar)";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_wolf_colour(6));
				$nid = Pets::WOLF;
				break;
			case Pets::WOLF_LIME : 
				$name = "Dog (Lime Collar)";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_wolf_colour(5));
				$nid = Pets::WOLF;
				break;
			case Pets::WOLF_YELLOW :
				$name = "Dog (Yellow Collar)";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_wolf_colour(4));
				$nid = Pets::WOLF;
				break;
			case Pets::WOLF_LIGHT_BLUE :
				$name = "Dog (Light Blue Collar)";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_wolf_colour(3));
				$nid = Pets::WOLF;
				break;
			case Pets::WOLF_MAGENTA : 
				$name = "Dog (Megenta Collar)";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_wolf_colour(2));
				$nid = Pets::WOLF;
				break;
			case Pets::WOLF_ORANGE :
				$name = "Dog (Orange Collar)";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_wolf_colour(1));
				$nid = Pets::WOLF;
				break;
			case Pets::WOLF_WHITE :
				$name = "Dog (White Collar)";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_wolf_colour(0));
				$nid = Pets::WOLF;
				break;
			case Pets::WOLF_EVIL :
				$name = "Evil Wolf";
				$meta = array_replace($meta, Pets::meta_wolf_evil(), Pets::meta_wolf_colour(0));
				$nid = Pets::WOLF;
				break;
			case Pets::SHEEP_BLACK :
				$name = "Black Sheep";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_sheep_colour(15));
				$nid = Pets::SHEEP;
				break;
			case Pets::SHEEP_RED :
				$name = "Red Sheep";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_sheep_colour(14));
				$nid = Pets::SHEEP;
				break;
			case Pets::SHEEP_GREEN :
				$name = "Green Sheep";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_sheep_colour(13));
				$nid = Pets::SHEEP;
				break;
			case Pets::SHEEP_COCOA :
				$name = "Cocoa Sheep";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_sheep_colour(12));
				$nid = Pets::SHEEP;
				break;
			case Pets::SHEEP_LAPIS :
				$name = "Lapis Sheep";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_sheep_colour(11));
				$nid = Pets::SHEEP;
				break;
			case Pets::SHEEP_PURPLE :
				$name = "Purple Sheep";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_sheep_colour(10));
				$nid = Pets::SHEEP;
				break;
			case Pets::SHEEP_CYAN :
				$name = "Cyan Sheep";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_sheep_colour(9));
				$nid = Pets::SHEEP;
				break;
			case Pets::SHEEP_LIGHT_GREY :
				$name = "Light Grey Sheep";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_sheep_colour(8));
				$nid = Pets::SHEEP;
				break;
			case Pets::SHEEP_GREY :
				$name = "Grey Sheep";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_sheep_colour(7));
				$nid = Pets::SHEEP;
				break;
			case Pets::SHEEP_PINK :
				$name = "Pink Sheep";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_sheep_colour(6));
				$nid = Pets::SHEEP;
				break;
			case Pets::SHEEP_LIME :
				$name = "Lime Sheep";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_sheep_colour(5));
				$nid = Pets::SHEEP;
				break;
			case Pets::SHEEP_YELLOW :
				$name = "Yellow Sheep";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_sheep_colour(4));
				$nid = Pets::SHEEP;
				break;
			case Pets::SHEEP_LIGHT_BLUE :
				$name = "Light Blue Sheep";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_sheep_colour(3));
				$nid = Pets::SHEEP;
				break;
			case Pets::SHEEP_MAGENTA :
				$name = "Megenta Sheep";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_sheep_colour(2));
				$nid = Pets::SHEEP;
				break;
			case Pets::SHEEP_ORANGE :
				$name = "Orange Sheep";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_sheep_colour(1));
				$nid = Pets::SHEEP;
				break;
			case Pets::SHEEP_WHITE :
				$name = "White Sheep";
				$meta = array_replace($meta, Pets::meta_tame(), Pets::meta_sheep_colour(0));
				$nid = Pets::SHEEP;
				break;
		}
		return ( is_null($name) || is_null($nid) ) ? null : new PetType($nid, $uid, $name, $meta);
	}
}