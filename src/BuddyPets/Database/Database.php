<?php
namespace BuddyPets\Database;
use BuddyPets\Entities\Pets;
use BuddyPets\Database\PetProperties;
use BuddyPets\PetOwner;
use BuddyPets\Main;

class Database {
	private $plugin;
	private $website;
	private $lastOwnerError = [];
	private $db;
	private $db_statements = [];
	private $tables = [];
	
	function __construct(\BuddyPets\Main $plugin) {
		$this->plugin = $plugin;
		$this->db_statements = array ();
		$this->website = $this->plugin->read_cfg ( "website" );
		$this->tables = array (
				"buddypets-db-table" => $this->plugin->read_cfg ( "buddypets-db-table" )
		);
		// try and open connection
		$this->db = new \mysqli (
			$this->plugin->read_cfg ( "mysql-server" ),
			$this->plugin->read_cfg ( "mysql-user" ), 
			$this->plugin->read_cfg ( "mysql-pass" ), 
			$this->plugin->read_cfg ( "database" )
		);
		if ($this->db->connect_errno) {
			$errmsg = $this->criticalError ( "Error connecting to database: " . $db->error );
		}
		$this->database_Setup ();
		$this->prepareStatements ();
	}
	
	private function criticalError($errmsg) {
		$errmsg = Main::translateColors ( "&", Main::PREFIX . $errmsg );
		$this->plugin->getServer ()->getInstance ()->getLogger ()->critical ( $errmsg );
		$this->plugin->getServer ()->getInstance ()->shutdown ();
	}
	
	function database_Setup() {
		 $sql = "
                CREATE TABLE IF NOT EXISTS `" . $this->tables["buddypets-db-table"] . "` (
                `owner` VARCHAR(50),
                `petName` VARCHAR(50),
                `petType` INT,
                `petSubType` INT,
                `petIsBaby` INT,
                `petActivationEnd` BIGINT,
                PRIMARY KEY (`owner`)
                );
        ";
        $this->db->query($sql);
	}
	
	function prepareStatements() {
		$thisQueryName = "setPet";
		$sql = "INSERT INTO `" . $this->tables["buddypets-db-table"] . "`
                        (`owner`, `petName`, `petType`, `petSubType`, `petIsBaby`)
                        VALUES
                        (?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                        `petName` = ?,
                        `petType` = ?,
                        `petSubType` = ?,
                        `petIsBaby` = ?
                ;
		";
		$this->checkPreparedStatement($thisQueryName, $sql);
		
		$thisQueryName = "getPet";
		$sql = "SELECT `petName`, `petType`, `petSubType`, `petIsBaby`,
				(FROM_UNIXTIME(`petActivationEnd`)>NOW()) AS `isActive`
				FROM `" . $this->tables["buddypets-db-table"] . "` WHERE `owner` = ?;";
		$this->checkPreparedStatement($thisQueryName, $sql);
	}
	
	private function checkPreparedStatement($queryname, $sql) {
		if (! isset ( $this->db_statements [$queryname] )) {
			$this->db_statements [$queryname] = $this->db->prepare ( $sql );
		}
		if ($this->db_statements [$queryname] === false) {
			$this->criticalError ( "Database error preparing query for  " . $queryname . ": " . $this->db->error );
			return false;
		}
		return true;
	}
	
	public function getPetProperties(PetOwner $petOwner) {
        $st = $this->db_statements["getPet"];

        $result = $st->bind_param( "s", $petOwner->playerName_lower );
        if ( ! $result ) {
                $this->criticalError( "Could not bind param: " . $st->error );
				return null;
        }

        $result = $st->execute();
        if ( ! $result ) {
                $this->criticalError( "Could not execute statement: " . $st->error );
				return null;
        }

        $result = $st->bind_result( $petName, $petType, $petSubType, $petIsBaby, $isActive );
        if ( ! $result ) {
                $this->criticalError( "Could not bind result: " . $st->error );
				return null;
        }
		
        if( $st->fetch() ) {
			$petProps = New PetProperties($petName, $petSubType, $petIsBaby, $isActive);
			$st->free_result();
			return $petProps;
		}

        $this->lastOwnerError[$petOwner->playerName_lower] =
			"You do not appear to have set up a pet. Login to $this->website to set one up.";
		return null;
	}
	
	public function getLastOwnerError(PetOwner $petOwner) {
		if( isset( $this->lastOwnerError[ $petOwner->playerName_lower ] ) ) {
			return $this->lastOwnerError[ $petOwner->playerName_lower ];
		}
		return "Unknown error";
	}
}