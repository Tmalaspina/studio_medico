<?php
 require ("../require/db_settings.php");

// Create connection
$conn = new mysqli("$db_server:$db_port", $db_login, $db_password, $db_dbName);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id, id_evento, id_paziente, id_sala, id_terapista FROM appuntamenti where id_evento='" . $_POST['id_evento'] . "'";
$result = $conn->query($sql);
$events = array();

if ($result->num_rows > 0) {
    // output data of each row

    while($data = $result->fetch_assoc()) {
        array_push(
				$events,
				array(
					$data['id'],
					$data['id_evento'],
					$data['id_paziente'],
					$data['id_sala'],
					$data['id_terapista']
				)
			);
    }
	
} 

echo json_encode($events);
$conn->close();

?>