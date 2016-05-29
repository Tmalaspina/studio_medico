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
			
			$ds= explode("-", $_POST['data_sheet']);
			$ds_Y = $ds[2];
			$ds_m = $ds[1];
			$ds_d = $ds[0];
			$ds_Ymd= $ds_Y . "-" . $ds_m . "-" .$ds_d;
			
			$sql = "UPDATE disponibilita_orari SET dalleore='" . $_POST['dalleore'] . "', alleore='" . $_POST['alleore'] . "' where id_terapista='" . $_POST['peopleSelectedId'] . "' and data='" . $ds_Ymd . "'";
			
			$sqls = array(0 => $sql);
			
			for ($i=0, $res= true; $i < count($sqls) && $res; $i++) {
				$res= $conn->query($sqls[$i]);
			}
			if ($res === true) {
			?>
                 <span class="text-success text-bold">Orario del <?php echo $_POST['data_sheet']; ?> aggiornato correttamente</span><br>
                 
                 <form method="post" action="/studio_medico/sale_richiama1.php">
                     <div class="right-align">
                        <input type="hidden" name="data_sheet" value="<? echo $_POST['data_sheet'] ?>">
                        <button type="submit" class="btn btn-default">Vai a Calendario</button>
                     </div>
                 </form>
                 
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