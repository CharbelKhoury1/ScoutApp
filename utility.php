<?php

function connection(){
	$conn=mysqli_connect("127.0.0.1","root","","scoutproject") or die( "Failed to connect to database: ". mysqli_error($conn));
	return $conn;
}
?>