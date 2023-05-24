<?php
function connection(){
	$con=mysqli_connect("127.0.0.1","root","","scoutproject") or die( "Failed to connect to database: ".mysql_error());
	return $con;
}
?>