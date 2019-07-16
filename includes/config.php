<?php 
// DB credentials.
/*
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','educational_portal');
*/
// Establish database connection.
try{
	//"mysql:host=localhost;dbname=educational_portal"
	$dsn = 'mysql:host=localhost;dbname=educational_portal';
	$conn = new PDO($dsn, 'root', '');
}
catch(exception $e)
{
	echo "Unable to connect to database";
}
date_default_timezone_set('Asia/Kuala_Lumpur');

?>