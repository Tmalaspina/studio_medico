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
			// Create connection
			$conn = new mysqli("$db_server:$db_port", $db_login, $db_password, $db_dbName);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 
		
			$sql = "UPDATE anagrafica SET nome='" . $_POST['nome'] . "', cognome='" . $_POST['cognome'] . "', indirizzo='" . $_POST['indirizzo'] . "', cap='" . $_POST['cap'] . "', citta='" . $_POST['citta'] . "' WHERE id='" . $_POST['peopleSelectedId'] ."'";

			if ($conn->query($sql) === TRUE) {
				?>
                 <span class="text-success text-bold">Record aggiornato correttamente</span><br>
                 <div class="left-align">
                 <table class="table table-bordered">
                        <tr><td><span class="text-bold">Nome:</span></td><td><?php echo $_POST['nome']?></td></tr>
                        <tr><td><span class="text-bold">Cognome:</span></td><td><?php echo $_POST['cognome']?></td></tr>
                        <tr><td><span class="text-bold">Indirizzo:</span></td><td><?php echo $_POST['indirizzo']?></td></tr>
                        <tr><td><span class="text-bold">CAP:</span></td><td><?php echo $_POST['cap']?></td></tr>
                        <tr><td><span class="text-bold">Città:</span></td><td><?php echo $_POST['citta']?></td></tr>
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
				<span class="text-danger text-bold text-center">Errore nell'aggiornamento del record</span> <?php $conn->error;
			}
			
			$conn->close();
		?>
        </p>
      

    </div><!-- /.container -->

</body>
</html>