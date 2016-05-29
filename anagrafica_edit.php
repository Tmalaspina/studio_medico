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
	<?php require ("require/db_settings.php"); ?>
    
    <div class="container">
        <?php
		$h2="Modifica scheda anagrafica per " . $_POST['peopleName'] . " " . $_POST['peopleSurname'];  
		require("require/bodyHeader.php");?>
        <p class="lead">
        <?php
			// Create connection
			$conn = new mysqli("$db_server:$db_port", $db_login, $db_password, $db_dbName);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 
			
			$sql = 'select * from anagrafica where id="' . $_POST['peopleSelectedId'] .'"';
					
			$result = $conn->query($sql);
			if ($result->num_rows > 0) { 
				while($row = $result->fetch_assoc()) {
			?>
            <form method="post" action="/studio_medico/anagrafica_doEdit.php">
            	<input type="hidden" name="peopleSelectedId" value="<?php echo $_POST['peopleSelectedId']; ?>" >
                <div class="left-align little-padding">
            
                  <label class="radio-inline" >
                  	<?php if ($row['tipo']=="T")  { ?>
					  <input type="radio" name="tipo" id="radioTerapista" value="T" checked disabled="disabled">
					<?php } else {?>
				  	
                    <input type="radio" name="tipo" id="radioTerapista" value="T"  disabled="disabled">
					<?php }?>
                  		<strong>Terapista </strong>
                  </label>
                
                
                 <label class="radio-inline" >
                  	<?php if ($row['tipo']=="P")  { ?>
					  <input type="radio" name="tipo" id="radioPaziente" value="P" checked disabled="disabled">
					<?php } else {?>
				  	
                    <input type="radio" name="tipo" id="radioPaziente" value="P"  disabled="disabled">
					<?php }?>
                  		<strong>Paziente </strong>
                  </label>
            
            	</div>
            	<div class="form-group">
    				<label for="nome">Nome</label>
    				<input type="text" name="nome" class="form-control" id="nome" placeholder="Nome" value="<?php echo $row['nome'] ?>">
  				</div>
                <div class="form-group">
    				<label for="cognome">Cognome</label>
    				<input type="text" name="cognome" class="form-control" id="cognome" placeholder="Cognome" value="<?php echo $row['cognome'] ?>">
  				</div>
                <div class="form-group">
    				<label for="indirizzo">Indirizzo</label>
    				<input type="text" name="indirizzo" class="form-control" id="indirizzo" placeholder="Indirizzo" value="<?php echo $row['indirizzo'] ?>">
  				</div>
                <div class="form-group">
    				<label for="cap">CAP</label>
    				<input type="text" name="cap" class="form-control" id="cap" placeholder="CAP" value="<?php echo $row['cap'] ?>">
  				</div>
                <div class="form-group">
    				<label for="citta">Città</label>
    				<input type="text" name="citta" class="form-control" id="citta" placeholder="Città" value="<?php echo $row['citta'] ?>">
  				</div>
                <div class="right-align">
                <button type="submit" class="btn btn-default">OK</button>
                </div>
            </form>
            <?php 
					$peopleSelectedId= $row['id'];
				} 
			}
			?>
        </p>
    </div><!-- /.container -->

</body>
</html>