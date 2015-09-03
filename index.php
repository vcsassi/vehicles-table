
<html>
	<head>
	<meta charset="utf-8">
	</head>
	<body>
		<?php

			require('dvconnect.inc.php');
			
			$conn = new mysqli($host, $db_user, $db_password, $dbname);
			
			
			if($conn->connect_error){

				die("We could not connect" . $conn->connect_error);
			} 
			$theSnazzySql =  "SELECT * FROM vehicles LEFT OUTER JOIN makers ON makers.id = vehicles.make_id";
			$result = $conn->query($theSnazzySql);
			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){

					echo " Make: ". $row["id"]; . " Type: " .$row["type"]; . " Engine: ".$row["engine"]; . " Year: ".$row["year"]; ." Fuel: ".$row["fuel"] . " Model: ".$row["model"] . "</br>";
				}
			}
			$conn->close();
		?>

	</body>
</html>