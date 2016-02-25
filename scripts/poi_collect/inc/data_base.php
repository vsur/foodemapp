<?php
  require_once 'control_functions.php';

  // require '../../../sec/givexml.php';
  // $secKeys = getSecVars('../../../sec/');

  class DataBase {
    private static $pdo = null;

    private static function conf() {
      global $secKeys;
      return [
      	'driver'	=>	'mysql',
      	'host'		=> 	'localhost',
      	'user'		=> 	$secKeys->cakeVars->{'dbUsr'},
      	'pass'		=> 	$secKeys->cakeVars->{'dbPw'},
      	'database'	=> 	$secKeys->cakeVars->{'dbCake'},
      	// 'user'		=> 	'root',
      	// 'pass'		=> 	'root',
      	// 'database'	=> 	'root',
      	'engine'	=>	'InnoDB',
      ];
    }

    public static function connect(){
  		$conf= self::conf();
  		$conn=$conf['driver'].':host='.$conf['host'].';dbname='.$conf['database'];
  		self::$pdo = self::$pdo ?: new \PDO($conn, $conf['user'], $conf['pass']);
  	}

  }

?>
