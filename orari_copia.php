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
    <?php require ("require/db_settings.php");?>
        <?php  require("require/bodyHeader.php");?>
        <p class="lead">
        <?php
			
			// Create connection
			$conn = new mysqli("$db_server:$db_port", $db_login, $db_password, $db_dbName);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 
			
			$ds= explode("-", $_POST['data_sheet']);
			$ds_Y = $ds[2];
			$ds_m = $ds[1];
			$ds_d = $ds[0];
			$ds_Ymd= $ds_Y . "-" . $ds_m . "-" .$ds_d;
			
			// sql to delete a record
			$sql = "DELETE FROM disponibilita_orari WHERE data='" . $ds_Ymd . "'";
			
			if ($conn->query($sql) === TRUE) {
				$sql2= "insert into disponibilita_orari (id_terapista, data, giorno, dalleore, alleore) select id_terapista, '" . $ds_Ymd . "', giorno, dalleore, alleore from template_orari where giorno=date_format('". $ds_Ymd."','%W')";
				if ($conn->query($sql2) === TRUE) {?>
					<span class="text-success text-bold text-center">Copia effettuata correttamente</span> 
					<form method="post" action="sale_richiama1.php">
                    	<input type="hidden" name="id_terapista" value=<?php echo '"' . $_POST['id_terapista_sel'] . '"' ?>>
                        <input type="hidden" name="data_sheet" value=<?php echo '"' . $_POST['data_sheet'] . '"' ?>>
                        <input type="hidden" name="peopleSelectedId" id="peopleSelectedId" value=<?php echo '"' . $_POST['peopleSelectedId'] . '"'?>>
                        <input type="hidden" name="peopleName" id="peopleName" value=<?php echo '"' . $_POST['peopleName'] . '"'?>>
            			<input type="hidden" name="peopleSurname" id="peopleSurname" value=<?php echo '"' . $_POST['peopleSurname'] . '"'?>>
                        <div class="right-align"><button type="submit" class="btn btn-default">Vai a Calendario</button></div>
                    </form>
					<?php
				} else {?>
                <span class="text-danger text-bold text-center">Errore nell' inserimento del record</span> <?php echo $conn->error;
				}
			} else {?>
				<span class="text-danger text-bold text-center">Errore nella cancellazione del record</span> <?php echo $conn->error;
			}
			
			$conn->close();
		?>

        </p>
      

    </div><!-- /.container -->

</body>
</html>