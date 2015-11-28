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
	const SHEEP = 13;
	const MOOSHROOM = 16;
	const SQUID = 17;
	
	const RABBIT = 18;
	const RABBIT_TYPE_INDEX = 18;
	const RABBIT_BROWN = 1800;
	const RABBIT_BLACK = 1801;
	const RABBIT_ALBINO = 1802;
	const RABBIT_SPOTTED = 1803;
	const RABBIT_SALT_AND_PEPPER = 1804;
	const RABBIT_GOLDEN = 1805;
	
	const BAT = 19;
	const IRON_GOLEM = 20;
	const SNOW_GOLEM = 21;
	
	const CAT = 22;
	const CAT_TYPE_INDEX = 18;
	const CAT_WILD = 2200;
	const CAT_TUXEDO = 2201;
	const CAT_TABBY = 2202;
	const CAT_SIAMESE = 2203;
	
	const WOLF = 14;
	const WOLF_TAME_INDEX = 17;
	const WOLF_TAME_BIT = 0x04;
	const WOLF_COLLAR_INDEX = 20;
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
	
	const PETDATA_UID = 1;
	const PETDATA_NETWORK_ID = 2;
	const PETDATA_NAME = 3;
	const PETDATA_METADATA =4;

	const DATATYPE_BYTE = 0;
	
	public static function getPetType($uid) {
		switch($uid) {
			case Pets::MOOSHROOM :
				return new PetType($uid, $uid, "MOOSHROOM");
				break;
			case Pets::SHEEP :
				return new PetType($uid, $uid, "SHEEP");
				break;
			case Pets::PIG :
				return new PetType($uid, $uid, "PIG");
				break;
			case Pets::COW :
				return new PetType($uid, $uid, "COW");
				break;
			case Pets::CHICKEN :
				return new PetType($uid, $uid, "CHICKEN");
				break;
			case Pets::BLAZE :
				return new PetType($uid, $uid, "BLAZE");
				break;
			case Pets::MAGMA_CUBE :
				return new PetType($uid, $uid, "MAGMA_CUBE");
				break;
			case Pets::CAVE_SPIDER :
				return new PetType($uid, $uid, "CAVE_SPIDER");
				break;
			case Pets::ENDERMAN :
				return new PetType($uid, $uid, "ENDERMAN");
				break;
			case Pets::SLIME :
				return new PetType($uid, $uid, "SLIME");
				break;
			case Pets::SPIDER :
				return new PetType($uid, $uid, "SPIDER");
				break;
			case Pets::SKELTON :
				return new PetType($uid, $uid, "SKELTON");
				break;
			case Pets::ZOMBIE :
				return new PetType($uid, $uid, "ZOMBIE");
				break;
			case Pets::CREEPER :
				return new PetType($uid, $uid, "CREEPER");
				break;
			case Pets::RABBIT_BROWN : 
				return new PetType(Pets::RABBIT, $uid, "Brown Rabbit", 
					[RABBIT_TYPE_INDEX => [DATATYPE_BYTE, 0]]);
				break;
			case Pets::RABBIT_BLACK :
				return new PetType(Pets::RABBIT, $uid, "Black Rabbit", 
					[RABBIT_TYPE_INDEX => [DATATYPE_BYTE, 1]]);
				break;
			case Pets::RABBIT_ALBINO :
				return new PetType(Pets::RABBIT, $uid, "Albino Rabbit", 
					[Pets::RABBIT_TYPE_INDEX => [Pets::DATATYPE_BYTE, 2]]);
				break;
			case Pets::RABBIT_SPOTTED :
				return new PetType(Pets::RABBIT, $uid, "Spotted Rabbit", 
					[Pets::RABBIT_TYPE_INDEX => [Pets::DATATYPE_BYTE, 3]]);
				break;
			case Pets::RABBIT_SALT_AND_PEPPER :
				return new PetType(Pets::RABBIT, $uid, "SaltNPetter Rabbit", 
					[Pets::RABBIT_TYPE_INDEX => [Pets::DATATYPE_BYTE, 4]]);
				break;
			case Pets::RABBIT_GOLDEN :
				return new PetType(Pets::RABBIT, $uid, "Golden Rabbit", 
					[Pets::RABBIT_TYPE_INDEX => [Pets::DATATYPE_BYTE, 5]]);
				break;
			case Pets::CAT_WILD :
				return new PetType(Pets::CAT, $uid, "Wild Cat", 
					[Pets::CAT_TYPE_INDEX => [Pets::DATATYPE_BYTE, 0]]);
				break;
			case Pets::CAT_TUXEDO :
				return new PetType(Pets::CAT, $uid, "Tuxedo Cat", 
					[Pets::CAT_TYPE_INDEX => [Pets::DATATYPE_BYTE, 1]]);
				break;
			case Pets::CAT_TABBY : 
				return new PetType(Pets::CAT, $uid, "Tabby Cat", 
					[Pets::CAT_TYPE_INDEX => [Pets::DATATYPE_BYTE, 2]]);
				break;
			case Pets::CAT_SIAMESE :
				return new PetType(Pets::CAT, $uid, "Siamese Cat", 
					[Pets::CAT_TYPE_INDEX => [Pets::DATATYPE_BYTE, 3]]);
				break;
			case Pets::WOLF_WILD :
				return new PetType(Pets::WOLF, $uid, "Wild Wolf",
					[Pets::WOLF_TAME_INDEX => [Pets::DATATYPE_BYTE, 0], Pets::WOLF_COLLAR_INDEX => [Pets::DATATYPE_BYTE, 0]] );
				break;
			case Pets::WOLF_BLACK : 
				return new PetType(Pets::WOLF, $uid, "Dog (Black Collar)", 
					[Pets::WOLF_TAME_INDEX => [Pets::DATATYPE_BYTE, Pets::WOLF_TAME_BIT],Pets::WOLF_COLLAR_INDEX => [Pets::DATATYPE_BYTE, 15]] );
				break;
			case Pets::WOLF_RED :
				return new PetType(Pets::WOLF, $uid, "Dog (Red Collar)", 
					[Pets::WOLF_TAME_INDEX => [Pets::DATATYPE_BYTE, Pets::WOLF_TAME_BIT],Pets::WOLF_COLLAR_INDEX => [Pets::DATATYPE_BYTE, 14]] );
				break;
			case Pets::WOLF_GREEN :
				return new PetType(Pets::WOLF, $uid, "Dog (Green Collar)", 
					[Pets::WOLF_TAME_INDEX => [Pets::DATATYPE_BYTE, Pets::WOLF_TAME_BIT],Pets::WOLF_COLLAR_INDEX => [Pets::DATATYPE_BYTE, 13]] );
				break;
			case Pets::WOLF_COCOA :
				return new PetType(Pets::WOLF, $uid, "Dog (Cocoa Collar)", 
					[Pets::WOLF_TAME_INDEX => [Pets::DATATYPE_BYTE, Pets::WOLF_TAME_BIT],Pets::WOLF_COLLAR_INDEX => [Pets::DATATYPE_BYTE, 12]] );
				break;
			case Pets::WOLF_LAPIS : 
				return new PetType(Pets::WOLF, $uid, "Dog (Lapis Collar)",  
					[Pets::WOLF_TAME_INDEX => [Pets::DATATYPE_BYTE, Pets::WOLF_TAME_BIT],Pets::WOLF_COLLAR_INDEX => [Pets::DATATYPE_BYTE, 11]] );
				break;
			case Pets::WOLF_PURPLE :
				return new PetType(Pets::WOLF, $uid, "Dog (Purple Collar)", 
					[Pets::WOLF_TAME_INDEX => [Pets::DATATYPE_BYTE, Pets::WOLF_TAME_BIT],Pets::WOLF_COLLAR_INDEX => [Pets::DATATYPE_BYTE, 10]] );
				break;
			case Pets::WOLF_CYAN : 
				return new PetType(Pets::WOLF, $uid, "Dog (Cyan Collar)", 
					[Pets::WOLF_TAME_INDEX => [Pets::DATATYPE_BYTE, Pets::WOLF_TAME_BIT],Pets::WOLF_COLLAR_INDEX => [Pets::DATATYPE_BYTE, 9]] );
				break;
			case Pets::WOLF_LIGHT_GREY :
				return new PetType(Pets::WOLF, $uid, "Dog (Light Grey Collar)", 
					[Pets::WOLF_TAME_INDEX => [Pets::DATATYPE_BYTE, Pets::WOLF_TAME_BIT],Pets::WOLF_COLLAR_INDEX => [Pets::DATATYPE_BYTE, 8]] );
				break;
			case Pets::WOLF_GREY :
				return new PetType(Pets::WOLF, $uid, "Dog (Grey Collar)", 
					[Pets::WOLF_TAME_INDEX => [Pets::DATATYPE_BYTE, Pets::WOLF_TAME_BIT],Pets::WOLF_COLLAR_INDEX => [Pets::DATATYPE_BYTE, 7]] );
				break;
			case Pets::WOLF_PINK : 
				return new PetType(Pets::WOLF, $uid, "Dog (Pink Collar)", 
					[Pets::WOLF_TAME_INDEX => [Pets::DATATYPE_BYTE, Pets::WOLF_TAME_BIT],Pets::WOLF_COLLAR_INDEX => [Pets::DATATYPE_BYTE, 6]] );
				break;
			case Pets::WOLF_LIME : 
				return new PetType(Pets::WOLF, $uid, "Dog (Lime Collar)", 
					[Pets::WOLF_TAME_INDEX => [Pets::DATATYPE_BYTE, Pets::WOLF_TAME_BIT],Pets::WOLF_COLLAR_INDEX => [Pets::DATATYPE_BYTE, 5]] );
				break;
			case Pets::WOLF_YELLOW :
				return new PetType(Pets::WOLF, $uid, "Dog (Yellow Collar)", 
					[Pets::WOLF_TAME_INDEX => [Pets::DATATYPE_BYTE, Pets::WOLF_TAME_BIT],Pets::WOLF_COLLAR_INDEX => [Pets::DATATYPE_BYTE, 4]] );
				break;
			case Pets::WOLF_LIGHT_BLUE :
				return new PetType(Pets::WOLF, $uid, "Dog (Light Blue Collar)", 
					[Pets::WOLF_TAME_INDEX => [Pets::DATATYPE_BYTE, Pets::WOLF_TAME_BIT],Pets::WOLF_COLLAR_INDEX => [Pets::DATATYPE_BYTE, 3]] );
				break;
			case Pets::WOLF_MAGENTA : 
				return new PetType(Pets::WOLF, $uid, "Dog (Magenta Collar)", 
					[Pets::WOLF_TAME_INDEX => [Pets::DATATYPE_BYTE, Pets::WOLF_TAME_BIT],Pets::WOLF_COLLAR_INDEX => [Pets::DATATYPE_BYTE, 2]] );
				break;
			case Pets::WOLF_ORANGE :
				return new PetType(Pets::WOLF, $uid, "Dog (Orange Collar)", 
					[Pets::WOLF_TAME_INDEX => [Pets::DATATYPE_BYTE, Pets::WOLF_TAME_BIT],Pets::WOLF_COLLAR_INDEX => [Pets::DATATYPE_BYTE, 1]] );
				break;
			case Pets::WOLF_WHITE :
				return new PetType(Pets::WOLF, $uid, "Dog (White Collar)", 
					[Pets::WOLF_TAME_INDEX => [Pets::DATATYPE_BYTE, Pets::WOLF_TAME_BIT],Pets::WOLF_COLLAR_INDEX => [Pets::DATATYPE_BYTE, 0]] );
				break;
		}
		return null;
	}
}