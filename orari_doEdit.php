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
    
    <?php $nav_active="Anagrafica" ?>
    <?php require ("require/nav.php");?>
    <?php require ("require/db_settings.php");?>

    <div class="container">
        <?php  require("require/bodyHeader.php");?>
        <p class="lead center-align">
        <?php
			function convertHour($datetime){
				$datetime = mysql_real_escape_string($datetime);
				$datetime = strtotime($datetime);
				$datetime = date('H:i:s',$datetime);
				return $datetime;
			}
			
			// Create connection
			$conn = new mysqli("$db_server:$db_port", $db_login, $db_password, $db_dbName);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 
		
			$sqlMo = "UPDATE template_orari SET dalleore='" . convertHour($_POST['Mon_dalleore']) . "', alleore='" . convertHour($_POST['Mon_alleore']) . "' where id_terapista='" . $_POST['peopleSelectedId'] . "' and giorno='Monday'";
			$sqlTu = "UPDATE template_orari SET dalleore='" . convertHour($_POST['Tue_dalleore']) . "', alleore='" . convertHour($_POST['Tue_alleore']) . "' where id_terapista='" . $_POST['peopleSelectedId'] . "' and giorno='Tuesday'";
			$sqlWe = "UPDATE template_orari SET dalleore='" . convertHour($_POST['Wed_dalleore']) . "', alleore='" . convertHour($_POST['Wed_alleore']) . "' where id_terapista='" . $_POST['peopleSelectedId'] . "' and giorno='Wednesday'";
			$sqlTh = "UPDATE template_orari SET dalleore='" . convertHour($_POST['Thu_dalleore']) . "', alleore='" . convertHour($_POST['Thu_alleore']) . "' where id_terapista='" . $_POST['peopleSelectedId'] . "' and giorno='Thursday'";
			$sqlFr = "UPDATE template_orari SET dalleore='" . convertHour($_POST['Fri_dalleore']) . "', alleore='" . convertHour($_POST['Fri_alleore']) . "' where id_terapista='" . $_POST['peopleSelectedId'] . "' and giorno='Friday'";
			$sqlSa = "UPDATE template_orari SET dalleore='" . convertHour($_POST['Sat_dalleore']) . "', alleore='" . convertHour($_POST['Sat_alleore']) . "' where id_terapista='" . $_POST['peopleSelectedId'] . "' and giorno='Saturday'";
			
			$sqls = array(0 => $sqlMo,
				$sqlTu, $sqlWe, $sqlTh, $sqlFr, $sqlSa);
			
			for ($i=0, $res= true; $i < count($sqls) && $res; $i++) {
				$res= $conn->query($sqls[$i]);
			}
			if ($res === true) {
			?>
                 <span class="text-success text-bold">Orario aggiornato correttamente</span><br>
                 <div class="left-align">
                 <table class="table table-striped">
                        <tr><td><span class="text-bold">Lunedì:</span></td><td></td><td></td><td></td></tr>
                        <tr><td><span class="text-bold">dalle ore:</span></td><td><?php echo $_POST['Mon_dalleore'] ?></td><td><span class="text-bold">alle ore:</span></td><td><?php echo $_POST['Mon_alleore'] ?></td></tr>
                        <tr><td><span class="text-bold">Martedì:</span></td><td></td><td></td><td></td></tr>
                        <tr><td><span class="text-bold">dalle ore:</span></td><td><?php echo $_POST['Tue_dalleore'] ?></td><td><span class="text-bold">alle ore:</span></td><td><?php echo $_POST['Tue_alleore'] ?></td></tr>
         				<tr><td><span class="text-bold">Mercoledì:</span></td><td></td><td></td><td></td></tr>
                        <tr><td><span class="text-bold">dalle ore:</span></td><td><?php echo $_POST['Tue_dalleore'] ?></td><td><span class="text-bold">alle ore:</span></td><td><?php echo $_POST['Tue_alleore'] ?></td></tr>
                        <tr><td><span class="text-bold">Giovedì:</span></td><td></td><td></td><td></td></tr>
                        <tr><td><span class="text-bold">dalle ore:</span></td><td><?php echo $_POST['Tue_dalleore'] ?></td><td><span class="text-bold">alle ore:</span></td><td><?php echo $_POST['Tue_alleore'] ?></td></tr>
                        <tr><td><span class="text-bold">Venerdì:</span></td><td></td><td></td><td></td></tr>
                        <tr><td><span class="text-bold">dalle ore:</span></td><td><?php echo $_POST['Tue_dalleore'] ?></td><td><span class="text-bold">alle ore:</span></td><td><?php echo $_POST['Tue_alleore'] ?></td></tr>
                        <tr><td><span class="text-bold">Sabato:</span></td><td></td><td></td><td></td></tr>
                        <tr><td><span class="text-bold">dalle ore:</span></td><td><?php echo $_POST['Tue_dalleore'] ?></td><td><span class="text-bold">alle ore:</span></td><td><?php echo $_POST['Tue_alleore'] ?></td></tr>               
                 </table>
                 <form method="post" action="/studio_medico/anagrafica_showSingle.php">
                     <div class="right-align">
                        <input type="hidden" name="peopleSelectedId" value="<? echo $_POST['peopleSelectedId'] ?>">
                        <button type="submit" class="btn btn-default">Vai a Scheda</button>
                     </div>
                 </form>
                 </div>
                <?php 
			} else { ?>
				<span class="text-danger text-bold text-center">Errore nell'aggiornamento del record</span> <?php echo $i . ' ' . $sqls[0] . $sqls[1]; $conn->error;
			}
			
			$conn->close();
		?>
        </p>
      

    </div><!-- /.container -->

</body>
</html>