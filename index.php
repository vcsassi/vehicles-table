
<html>
	<head>
	<meta charset="utf-8">

	</head>
	<body>




		<?php



		require '../../dbconnection.inc.php';

		$conn = new mysqli($host, $db_user, $db_password, $db_name);

		if($conn->connect_error){
			die("We could not connect" . $conn->connect_error);

		} 


		$theSnazzySql =  "SELECT vehicle.*, makers.name FROM vehicle
				  LEFT OUTER JOIN makers
				  ON makers.id = vehicle.make_id";

		$result = $conn->query($theSnazzySql);

		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo "<div>";
				echo " Make: ". $row["name"];
				echo " Model: ".$row["type"];
				echo " Engine: ".$row["engine"];
				echo " Year: ".$row["year"];
				echo " Fuel".$row["fuel"];
				echo " Model".$row["model"];

				echo "</div>";
			}
		}

		$conn->close();

		?>
	</body>
</html>