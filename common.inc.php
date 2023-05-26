<?php
function SecureData($data){
	$con=connection();
	$data=htmlspecialchars($data);
	$data=mysqli_real_escape_string($con,$data);
	mysqli_close($con);
	return $data;
}
?>