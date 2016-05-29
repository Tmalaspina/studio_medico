<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Studio Medico</title>
<link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
<link href="style.css" rel="stylesheet">
</head>

<body>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
    
    <?php $nav_active="Home" ?>
    <?php require ("require/nav.php");?>
    <?php require ("require/db_settings.php");?>

    <div class="container">
        <?php  require("require/bodyHeader.php");?>
        <div class="center-align">
        <p class="lead">
		<?php
			// Create connection
			$conn = new mysqli("$db_server:$db_port", $db_login, $db_password, $db_dbName);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 
			
			$sql= "SELECT max(id) as id FROM sale";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$newId = $row['id'] +1;
			
				$sql = "INSERT INTO sale (id, nome)
				VALUES ('" . $newId . "','". $_POST['nome_sala'] . "')";
			
				if ($conn->query($sql) === TRUE) {?>
					<span class="text-success text-bold">Record aggiornato correttamente</span><br>
				<?php } else { ?>
					<span class="text-danger text-bold">Errore nell'aggiornamento del record</span> <?php $conn->error;
				}
			}
			$conn->close();
        ?>
        </p>
         <div class="right-align">
        	<a class="btn btn-default" href="sale_gestione.php" role="button">Ritorna</a>
        </div>
	</div>
    </div><!-- /.container -->

</body>
</html>