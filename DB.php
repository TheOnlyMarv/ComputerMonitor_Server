<?PHP class DB {

private static $_instance = null;
private static $_pdo = false;



private function __construct(){
	
	 $_host = 'localhost';
	 $_db   = 'computer_monitor';
	 $_user = 'cm_handler';
	 $_pass = 'PASSWORD';
 
	 try {
		self::$_pdo = new PDO(
			'mysql:host=' . $_host .
			';dbname=' . $_db .
			';charset=UTF8',
			$_user,
			$_pass
		);
	} catch( PDOException $e ){ echo $e->getMessage(); }
}

private static function getInstance(){
	if( !isset( self::$_instance ) ) self::$_instance = new self();
	return self::$_instance;
}



// https://www.owasp.org/index.php/PHP_Security_Cheat_Sheet#PDO_Prepared_Statement_Wrapper
public static function query( $sql ){
	self::getInstance();
	$args = func_get_args();
	
	if( count( $args ) === 1 ){
		if( !$result = self::$_pdo->query( $sql ) ){
			$error = self::$_pdo->errorInfo();
			trigger_error('Unable to prepare statement: ' . $sql . '<br>Reason: ' . $error[2] );
			return false;
		}
		return $result->fetchAll( PDO::FETCH_ASSOC );
		
	} else {
		if( !$stmt = self::$_pdo->prepare( $sql ) ){
			$error = self::$_pdo->errorInfo();
			trigger_error('Unable to prepare statement: ' . $sql . '<br>Reason: ' . $error[2] );
			return false;
		}
		
		array_shift( $args ); //remove $sql from args
		$i = 0;
		foreach( $args as &$v )
			$stmt->bindValue( ++$i, $v, is_int( $v ) ? PDO::PARAM_INT : PDO::PARAM_STR );
		
		if( !$stmt->execute() ){
			$error = $stmt->errorInfo();
			trigger_error('Unable to prepare statement: ' . $sql . '<br>Reason: ' . $error[2] );
			return false;
		}
		return $stmt->fetchAll( PDO::FETCH_ASSOC );
		
	}
}

public static function lastID(){
	return self::$_pdo->lastInsertId();
}

} ?>