<?php
require('dvconnect.inc.php');
$title = "car table";
include("header.inc.php");
$row_class = "odd";
// Create connection
$conn = new mysqli($host, $db_user, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// inserting new record
if($_SERVER["REQUEST_METHOD"] == "POST"){


  $type = $_POST["car_type"];
  $engine = $_POST["car_engine"];
  $year = $_POST["car_year"];
  $fuel = $_POST["car_fuel"];
  $model = $_POST["car_model"];
  $make_id = $_POST["car_make"];
  //don't forget to quote your inserted variables :-(
  $sql_insert = "INSERT INTO vehicle (id, type, engine, year, fuel, model, make_id) VALUES (NULL, '$type' , '$engine', '$year', '$fuel', '$model', '$make_id')";

  if ($conn->query($sql_insert) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}

//delete requested record
if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["delete_id"])){
    $delete_id = $_GET["delete_id"];
    $sql_delete = "DELETE FROM vehicle WHERE id = '$delete_id'";
    if($conn->query($sql_delete) === TRUE) {
        echo "Record deleted";
    } else {
        echo "Error on delete:" . $sql_delete . "<br>" .$conn->error;
    }
}

// reading current cars
$sql = "SELECT vehicle.id, vehicle.type, vehicle.engine, vehicle.year, vehicle.fuel, vehicle.model, makers.name FROM vehicle LEFT OUTER JOIN makers ON makers.id = vehicle.make_id";
$result = $conn->query($sql);

// reading makers
$sql_makers = "SELECT * FROM makers";
$result_makers = $conn->query($sql_makers);

?>







<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vehicle Tables Assigment</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="content container">
      <h1>Table</h1>
      <div class="table responsive">
        <table class="table table-striped">

              
          <tr>
            <td><?php echo "<table class='vehicle'>\n"; ?></td>
            <td><?php echo "<tr class='header-row'>\n"; ?></td>
            <td><?php echo "\t<th>Type</th>\n"; ?></td>
            <td><?php echo "\t<th>Engine</th>\n"; ?></td>
            <td><?php echo "\t\t<th>Year</th>\n"; ?></td>
            <td><?php echo "\t\t<th>Fuel</th>\n"; ?></td>
            <td><?php echo "\t\t<th>Model</th>\n"; ?></td>
            <td><?php echo "\t\t<th>Delete</th>\n"; ?></td>
            <td><?php echo "</tr>\n"; ?></td>
          </tr>


        </table>

       <?php 
        if($result->num_rows > 0){
          while($row = $result->fetch_assoc()){

       ?>

       <tr>
            <td><?php echo "<tr class='data-row $row_class'>"; ?></td>
            <td><?php echo "<td>" . $row["type"] . "</td>"; ?></td>
            <td><?php echo "<td>" . $row["engine"] . "</td>"; ?></td>
            <td><?php echo "<td>" . $row["year"] . "</td>"; ?></td>
            <td><?php echo "<td>" . $row["fuel"] . "</td>"; ?></td>
            <td><?php echo "<td>" . $row["model"] . "</td>"; ?></td>
             <!-- <a href="mypage.php?delete_id=2">Delete</a> -->
            <td><?php echo "<td><a href=". $_SERVER["PHP_SELF"]. "?delete_id=".$row['id']."> delete</a></td>"; ?></td>
            <td><?php echo "</tr>"; ?></td>
            
          </tr>

          <?php
            if($row_class == "odd"){
              $row_class = "even";
            } else if($row_class == "even") {
              $row_class = "odd";
            }
          }
        } else {
          echo "0 results; nope";
        }
        echo "</table>";

        $conn->close();

        
        ?>
       </div> 
    

      <h1>Insert/Delete Records</h1>
        <div class="input-form">
          <form action="" method="post">
            <label for="newCarType"> Type:
              <input type="text" name="car_type" id="newCarType" />
            </label>
            <label for="newCarEngine"> Engine:
              <input type="text" name="car_engine" id="newCarEngine" />
            </label>
            <label for="newCarYear"> Year:
              <input type="text" name="car_year" id="newCarYear" />
            </label>
            <label for="newCarFuel"> Fuel:
              <input type="text" name="car_fuel" id="newCarFuel" />
            </label>
            <label for="newCarModel"> Model:
              <input type="text" name="car_model" id="newCarModel" />
            </label>
            <label for="newCarMake"> Make:
              <select name="car_make">
                <?php
                  if($result_makers->num_rows > 0){
                    while($maker_row = $result_makers->fetch_assoc()){
                      echo "<option value='".$maker_row["id"]."'>".$maker_row["name"]."</option>";
                    }
                  }
                ?>
              </select>
            </label>
            <button type="submit">Insert new car</button>

          </form>
        </div>
      </div>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
  </body>
</html>
<?php

?>