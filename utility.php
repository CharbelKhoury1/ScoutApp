<?php

function connection(){
	$con=mysqli_connect("127.0.0.1","root","","scoutproject") or die( "Failed to connect to database: ". mysqli_error($con));
	return $con;
}
?>