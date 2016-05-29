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
    <?php require ("require/nav.php"); ?>
	<?php require("require/db_settings.php"); ?>
    
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
				
				$sql= "SELECT max(id) as id FROM anagrafica";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
                    $newId = $row['id'] +1;
					
					$sql = 'INSERT INTO anagrafica (id, tipo, nome, cognome, indirizzo, cap, citta)
					VALUES ("' . $newId . '","' . $_POST['tipo'] . '","' . $_POST['nome'] . '","' . $_POST['cognome'] . '","' . $_POST['indirizzo'] . '","' . $_POST['cap'] . '","' . $_POST['citta'] . '")';
					
					if ($conn->query($sql) === TRUE) { 
						mkdir("referti/".$newId,0777,true);
						if ($_POST['tipo']=="T"){
							$sqlMo = "insert into template_orari (id_terapista, ordine_giorno, giorno, dalleore, alleore) values ('". $newId ."', '1', 'Monday', '9:00', '17:00')";
							$sqlTu = "insert into template_orari (id_terapista, ordine_giorno, giorno, dalleore, alleore) values ('". $newId ."', '2', 'Tuesday', '9:00', '17:00')";
							$sqlWe = "insert into template_orari (id_terapista, ordine_giorno, giorno, dalleore, alleore) values ('". $newId ."', '3', 'Wednesday', '9:00', '17:00')";
							$sqlTh = "insert into template_orari (id_terapista, ordine_giorno, giorno, dalleore, alleore) values ('". $newId ."', '4', 'Thursday', '9:00', '17:00')";
							$sqlFr = "insert into template_orari (id_terapista, ordine_giorno, giorno, dalleore, alleore) values ('". $newId ."', '5', 'Friday', '9:00', '17:00')";
							$sqlSa = "insert into template_orari (id_terapista, ordine_giorno, giorno, dalleore, alleore) values ('". $newId ."', '6', 'Saturday', '9:00', '17:00')";				
							$sqls = array(
								0 => $sqlMo, $sqlTu, $sqlWe, $sqlTh, $sqlFr, $sqlSa
								);
							
							for ($i=0, $res= true; $i < count($sqls) && $res; $i++) {
								$res= $conn->query($sqls[$i]);
							}
							if ($res === true) { ?>
								<span class="text-success text-bold">Record inserito con successo</span><br> <?php
							}
						} else {
					?>
						<span class="text-success text-bold">Record inserito con successo</span><br>
                    <?php } ?>
						<div class="left-align">
                        <div class="left-align little-padding">
            		
                  <label class="radio-inline" >
                  	<?php if ($_POST['tipo']=="T")  { ?>
					  <input type="radio" name="tipo" id="radioTerapista" value="T" checked="checked" disabled="disabled">
					<?php } else {?>
				  	
                    <input type="radio" name="tipo" id="radioTerapista" value="T"  disabled="disabled">
					<?php }?>
                  		<strong>Terapista </strong>
                  </label>
                
                
                 <label class="radio-inline" >
                  	<?php if ($_POST['tipo']=="P")  { ?>
					  <input type="radio" name="tipo" id="radioPaziente" value="P" checked="checked" disabled="disabled">
					<?php } else {?>
				  	
                    <input type="radio" name="tipo" id="radioPaziente" value="P"  disabled="disabled">
					<?php }?>
                  		<strong>Paziente </strong>
                  </label>
            
            	</div>
							<table class="table table-bordered">
							<tr><td><span class="text-bold">Nome:</span></td><td><?php echo $_POST['nome']?></td></tr>
							<tr><td><span class="text-bold">Cognome:</span></td><td><?php echo $_POST['cognome']?></td></tr>
							<tr><td><span class="text-bold">Indirizzo:</span></td><td><?php echo $_POST['indirizzo']?></td></tr>
							<tr><td><span class="text-bold">CAP:</span></td><td><?php echo $_POST['cap']?></td></tr>
							<tr><td><span class="text-bold">Città:</span></td><td><?php echo $_POST['citta']?></td></tr>
							</table>
						</div>
                        <form method="post" action="/studio_medico/anagrafica_showSingle.php">
                             <div class="right-align">
                             <input type="hidden" name="peopleSelectedId" value="<? echo $newId ?>">
                        	 <button type="submit" class="btn btn-default">Vai a Scheda</button>
                     		 </div>
                 		</form>
				<?php }
                } else { ?>
				<span class="text-danger text-bold">Errore: </span> <?php $conn->error;
			}
			
			$conn->close();
		?>
        </p>
    </div><!-- /.container -->

</body>
</html>