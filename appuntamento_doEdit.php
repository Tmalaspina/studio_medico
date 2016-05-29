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
        <p class="lead">
		<?php
            // Create connection
            $conn = new mysqli("$db_server:$db_port", $db_login, $db_password, $db_dbName);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 
            
          
					
                  
			$hourstart= "STR_TO_DATE('" . $_POST['dataAppuntamento_edit'] . " " . $_POST['oraAppuntamento_edit'] . "','%d-%m-%Y %H:%i')";

			$color= '327CCB';
			$duration= str_replace(',','.',$_POST['durataAppuntamento_edit']) ;
			$sql = 'UPDATE event SET name="' . $_POST['nomeAppuntamento_edit'] . '", event.desc="' . $_POST['descAppuntamento_edit'] . '", hourstart=' . $hourstart. ', duration= "' . $duration . '", color= "' . $color . '" where id="' . $_POST['id_appuntamento_edit'] . '"';
	
			if ($conn->query($sql) === TRUE) {?>
				<span class="text-success text-bold">Evento aggiornato correttamente</span><br> <?php
				if ($_POST['peopleSelectedId2_edit'] != '')
					$sql= 'UPDATE appuntamenti SET id_terapista="' . $_POST['id_terapista2_edit'] . '", id_paziente="' . $_POST['peopleSelectedId2_edit'] . '", id_sala="' . $_POST['id_sala2_edit'] . '" where id_evento="' . $_POST['id_appuntamento_edit'] .'"';
				else
					$sql= 'UPDATE appuntamenti SET id_terapista="' . $_POST['id_terapista2_edit'] . '", id_sala="' . $_POST['id_sala2_edit'] . '" where id_evento="' . $_POST['id_appuntamento_edit'] .'"';
				
				if ($conn->query($sql) === TRUE) { ?>
					<span class="text-success text-bold">Appuntamento aggiornato correttamente</span><br> <?php
				}
				else {
					echo "<span class='text-danger text-bold'>Errore: " . $sql . "</span><br>" . $conn->error;
				}
		   } else {
			   echo "<span class='text-danger text-bold'>Errore: " . $sql . "</span><br>" . $conn->error;
		   }
		   $conn->close();
        ?>
        </p>
        <form method="post" action="sale_richiama1.php">
        	<input type="hidden" name="data_sheet" id="data_sheet" value=<?php echo "'" . $_POST['data_sheet'] . "'"?> >
            <input type="hidden" name="peopleSelectedId" id="peopleSelectedId" value=<?php echo "'" . $_POST['peopleSelectedId2'] . "'"?> >
            <div class="right-align">
            	<button type="submit" class="btn btn-default">Vai a Calendario</button>
            </div>
        </form>
    </div><!-- /.container -->

</body>
</html>