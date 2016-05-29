<?php
 require ("../require/db_settings.php");

// Create connection
$conn = new mysqli("$db_server:$db_port", $db_login, $db_password, $db_dbName);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$days= array(
	"lunedì" => "Monday",
	"martedì" => "Tuesday",
	"mercoledì" => "Wednesday",
	"giovedì" => "Thursday",
	"venerdì" => "Friday",
	"sabato" => "Saturday",
	"domenica" => "Sunday"
);

$sql = "SELECT * FROM disponibilita_orari where id_terapista='" . $_POST['id_terapista'] . "' and data='" . $_POST['data_sheet'] . "'";
$result = $conn->query($sql);
$terapists = array();

if ($result->num_rows > 0) {
    // output data of each row

    while($data = $result->fetch_assoc()) {
        array_push(
				$terapists,
				array(
					$data['id_terapista'],
					$data['giorno'],
					$data['dalleore'],
					$data['alleore']
				)
			);
    }
	
} 

echo json_encode($terapists);
$conn->close();

?>