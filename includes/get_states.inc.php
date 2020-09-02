<?php
include('./conn.inc.php');

$sql = "SELECT id,name FROM regions WHERE country_id = '".$_POST['id']."' ORDER BY name";

$result = mysqli_query($conn, $sql);


    // output data of each row
while($row = mysqli_fetch_assoc($result)) {


	$data['value']=$row['id'];
	$data['label']=$row['name'];
	$json[]=$data;      
}
echo json_encode($json);


mysqli_close($conn);
?> 