<?php
function SecureData($data){
	$conn=connection();
	$data=htmlspecialchars($data);
	$data=mysqli_real_escape_string($conn,$data);
	mysqli_close($conn);
	return $data;
}

?>