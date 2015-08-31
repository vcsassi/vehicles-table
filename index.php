<?php


require("../../../dbconnection.inc.php");

$conn = new mysqli($host, $db_user, $db_password, $db_name);

if($conn->connect_error){
	die("We could not connect" . $conn->connect_error);
} 

$theSnazzySql =  "SELECT * FROM vehicles 
		  LEFT OUTER JOIN makers 
		  ON makers.id = vehicles.make_id";

$result = $conn->query($theSnazzySql);

if($result->num_rows > 0){
	while($row = $result->fetch_assoc()){
		echo "<div>";
		echo " Make: ". $row["name"];
		echo " Model: ".$row["model"];
		echo " Color: ".$row["color"];
		echo " Year: ".$row["year"];
		echo " Engine".$row["engine"];

		echo "</div>";
	}
}

$conn->close();

?>