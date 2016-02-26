<?php

  // Class based on http://www.html-seminar.de/html-css-php-forum/board40-themenbereiche/board18-php/4889-einfache-datenbankklasse-php-data-objects-erweiterung-pdo/

  class DataBase {
    private static $pdo = null;
    // private static $pdo = null;

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

    public static function connect($host, $username, $password, $database=null) {
      try {
        $database = ($database) ? ';dbname=' . $database : '';
        self::$pdo = new PDO('mysql:host=' . $host . $database, $username, $password);
        return;
       } catch (PDOException $e) {
        error_log( 'Database Error: ' . $e->getMessage());
        throw new Exception($e->getMessage());
       }
     }

    public static function fire($sql, $para=null) {
      // $sql: (string) as the query, but no multi-query support
      // $para: (array)
      // Example: array( 'name' => 'harry', 'limit' => 1)

      $para_copy = $para; // for later error reporting

      $stmt = self::$pdo->prepare($sql);

      // $bind_para = (if) ? then : else;
      $bind_para = ($para !== null and
          (strpos($sql, ' LIMIT :') !== false or strpos($sql, ' limit :') !== false)
        ) ? true : false;

      if($bind_para and is_array($para)) {
        foreach($para as $key => &$val) {
          if( is_string($val) ) {
            $stmt->bindParam($key, $val, PDO::PARAM_STR);
          }
          elseif( is_bool($val) ) {
            $stmt->bindParam($key, $val, PDO::PARAM_BOOL);
          }
          elseif( is_null($val) ) {
            $stmt->bindParam($key, $val, PDO::PARAM_NULL);
          }
          elseif( is_numeric($val) ) {
            $stmt->bindParam($key, $val, PDO::PARAM_INT);
          }
          else {
            $stmt->bindParam($key, (string)$val, PDO::PARAM_STR);
          }
        }
        $para = null;
      }

      if(!$stmt->execute($para)) {
      // Error management
      $err_info   = $stmt->errorInfo();
      $sql_state  = $err_info[0];
      $ecode      = $err_info[1];
      $emsg       = $err_info[2];

      $sql_state  = '(SQLSTATE: ' . $sql_state . ')';
      $ecode      = '(eCode: ' . $ecode . ')';
      $emsg       = 'eMessage: ' . $emsg;

      $error = $sql_state . ' ' . $emsg . ' ' . $ecode;

      $sql = preg_replace('/\s+/', ' ', $sql);

      $para_sring = '';
      if($para_copy) {
        foreach($para_copy as $k => $v) {
          $para_sring .= ($para_sring === '') ? '' : '; ';
          $para_sring .= ((strpos($k, ':') !== false) ? '' : ':') . $k . ' => ' . $v;
        }
      }

      $error .= 'query: ' . $sql . ' para: ' . $para_sring;
        throw new Exception($error);
      }

      // (->execute) without error
      $result = null;
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if($result === null) {
          $result = array();
        }
        $result[] = $row;
      }
      $stmt = null;
      return $result;
    }

    public static function close() {
      self::$pdo = null;
    }

    public function connectOld(){
  		$conf= self::conf();
  		$conn=$conf['driver'].':host='.$conf['host'].';dbname='.$conf['database'];
  		self::$pdo = self::$pdo ?: new \PDO($conn, $conf['user'], $conf['pass']);
  	}

    public static function lastInsertId() {
     return self::$pdo->lastInsertId();
    }

  }

?>
