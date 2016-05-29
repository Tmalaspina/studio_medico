<?php
 require ("../require/db_settings.php");

// Create connection
$conn = new mysqli("$db_server:$db_port", $db_login, $db_password, $db_dbName);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id,nome,'". $_POST['giorno'] ."' as giorno FROM anagrafica WHERE tipo='T' order by nome";
$result = $conn->query($sql);
$terapists = array();

if ($result->num_rows > 0) {
    // output data of each row

    while($data = $result->fetch_assoc()) {
        array_push(
				$terapists,
				array(
					$data['id'],
					$data['nome'],
					$data['giorno']
				)
			);
    }
	
} 

echo json_encode($terapists);
$conn->close();

?>