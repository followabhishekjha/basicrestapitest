<?php
	//$conn = new mysqli("n1plcpnl0017.prod.ams1.secureserver.net", "basicrestapitest", "basicrestapitest", "basicrestapitest"); // Creating connection
	$conn = new mysqli("160.153.16.16", "basicrestapitest", "basicrestapitest", "basicrestapitest"); // Creating connection
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	else
		echo "connected";
//https://n1plcpnl0017.prod.ams1.secureserver.net
/*

define("PATH","restapi");
define("HOST","localhost");
define("USER","root");
define("PWD","");
define("DATABASE","restapi");
*/
?>


