<?php
 require ("../require/db_settings.php");

// Create connection
$conn = new mysqli("$db_server:$db_port", $db_login, $db_password, $db_dbName);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM event where id='" . $_POST['id_appuntamento'] . "'";
$result = $conn->query($sql);
$events = array();

if ($result->num_rows > 0) {
    // output data of each row

    while($data = $result->fetch_assoc()) {
        array_push(
				$events,
				array(
					$data['id'],
					$data['name'],
					$data['desc'],
					$data['hourstart'],
					$data['duration'],
					$data['color']
				)
			);
    }
	
} 

echo json_encode($events);
$conn->close();

?>