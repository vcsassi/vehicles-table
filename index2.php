<?php

require('dvconnect.inc.php');
$title = "car table";
// include("header.inc.php");
$row_class = "odd";
// Create connection
$conn = new mysqli($host, $db_user, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// inserting new record
if($_SERVER["REQUEST_METHOD"] == "POST" && empty($_POST["update_flag"])){

  $type = filter_var($_POST["car_type"], FILTER_SANITIZE_STRING);
  $engine = filter_var($_POST["car_engine"], FILTER_SANITIZE_STRING);
  $year = filter_var($_POST["car_year"], FILTER_SANITIZE_STRING);
  $fuel = filter_var($_POST["car_fuel"], FILTER_SANITIZE_STRING);
  $model = filter_var($_POST["car_model"], FILTER_SANITIZE_STRING);
  $make_id = filter_var($_POST["car_make"], FILTER_SANITIZE_NUMBER_INT);

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

// Updating a record
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_flag"])){ 
  $type_update = filter_var($POST["car_type"], FILTER_SANITIZE_STRING);
  $engine_update = filter_var($_POST["car_engine"], FILTER_SANITIZE_STRING);
  $year_update = filter_var($_POST["car_year"], FILTER_SANITIZE_NUMBER_INT);
  $fuel_update = filter_var($_POST["car_fuel"], FILTER_SANITIZE_STRING);
  $model_update = filter_var($_POST["car_model"], FILTER_SANITIZE_STRING);
  $make_id_update = filter_var($_POST["car_make"], FILTER_SANITIZE_NUMBER_INT);
  $id_update = $_POST["update_flag"];
  $sql_update = "UPDATE vehicle SET model = '$model_update',
                type = '$type_update',
                engine = '$engine_update',
                year = 'year_update',
                fuel = 'fuel_update',
                model = 'model_update',
                make_id = '$make_id_update' WHERE id = $id_update";
  if ($conn->query($sql_update) === TRUE) {
    echo "Record updated successfully";
  } else {
    echo "Error: " . $sql_update . "<br>" . $conn->error;
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
    <link href="css/styles.css" rel="stylesheet">
  </head>
  <body>
    <div class="content container">
      <h2>Table / Delete Records</h2>


      <div class="table responsive">
        <table class="table table-striped">
          <tr>
            
            <td>Type</td>
            <td>Engine</td>
            <td>Year</td>
            <td>Fuel</td>
            <td>Model</td>
            <td>Delete</td>
          </tr>


       <?php 
        if($result->num_rows > 0){
          while($row = $result->fetch_assoc()){ // start loop

       ?>

       <tr>
           
            <td><?php echo $row["type"]; ?></td>
            <td><?php echo $row["engine"]; ?></td>
            <td><?php echo $row["year"]; ?></td>
            <td><?php echo $row["fuel"]; ?></td>
            <td><?php echo $row["model"]; ?></td>
            <td><?php echo $row["name"]; ?></td>
             <!-- <a href="mypage.php?delete_id=2">Delete</a> -->
            <td><a href="<?php echo  $_SERVER["PHP_SELF"];?> "?delete_id="<?php echo $row['id']?>"> delete</a></td>
          
            
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
        </table>
       </div> 
    

      <h2>Insert Records</h2>
        <div class="content">
          <div class="input-form">
            <form action="" method="post">

              <div class="col-md-6 entrada">
                <label class="col-md-12" for="newCarType"> Type:
                    <input class="col-md-12" type="text" name="car_type" id="newCarType" />
                </label>
              </div>
         

              <div class="col-md-6 entrada">
                <label class="col-md-12" for="newCarEngine"> Engine:
                  <input class="col-md-12" type="text" name="car_engine" id="newCarEngine" />
                </label>
              </div>

              <div class="col-md-6 entrada">
                <label class="col-md-12" for="newCarYear"> Year:
                  <input class="col-md-12" type="text" name="car_year" id="newCarYear" />
                </label>
              </div>

              <div class="col-md-6 entrada">
                <label class="col-md-12" for="newCarFuel"> Fuel:
                  <input class="col-md-12" type="text" name="car_fuel" id="newCarFuel" />
                </label>
              </div>

              <div class="col-md-6 entrada">
                <label class="col-md-12" for="newCarModel"> Model:
                  <input class="col-md-12" type="text" name="car_model" id="newCarModel" />
                </label>
              </div>
              <div class="col-md-6 entrada">
                <label class="col-md-12" for="newCarMake"> Make:
                  <select name="car_make">
                    <?php
                      if($result_makers->num_rows > 0){
                        while($maker_row = $result_makers->fetch_assoc()){
                          echo "<option value='".$maker_row["id"]."'>".$maker_row["name"]."</option>";
                        }
                      }
                    ?>
                  </select>
              </div>

              <div class="col-md-12 entrada">
                </label>
                <button class="btn btn-lg" type="submit">Insert new car</button>
              </div>
            </div>

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