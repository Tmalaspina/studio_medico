<?php
 require ("../require/db_settings.php");

// Create connection
$conn = new mysqli("$db_server:$db_port", $db_login, $db_password, $db_dbName);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT name, event.desc,hourstart,duration,id_terapista, date_format(hourstart,'%W') as day_week, event.id as id_appuntamento FROM event inner join appuntamenti on event.id=appuntamenti.id_evento where id_terapista='" . $_POST['id_terapista'] . "' and date_format(hourstart,'%d-%m-%Y')='". $_POST['giorno']."'";
$result = $conn->query($sql);
$terapists = array();

if ($result->num_rows > 0) {
    // output data of each row

    while($data = $result->fetch_assoc()) {
        array_push(
				$terapists,
				array(
					$data['name'],
					$data['desc'],
					$data['hourstart'],
					$data['duration'],
					$data['id_terapista'],
					$data['day_week'],
					$data['id_appuntamento']
				)
			);
    }
	
} 

echo json_encode($terapists);
$conn->close();

?>