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
    
    <?php $nav_active="Anagrafica"; ?>
    <?php require ("require/nav.php"); ?>
	<?php require ("require/db_settings.php"); ?>
    
    <div class="container">
        <?php  require("require/bodyHeader.php");?>
        <p class="lead">
        Scheda anagrafica
         <div class="left-align">
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
					$peopleName= $row['nome'];
					$peopleSurname= $row['cognome'];
					$tipo= $row['tipo'];
			?>
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
            <table class="table table-bordered">
            <tr><td><span class="text-bold">Nome:</span></td><td><?php echo $row['nome']?></td></tr>
            <tr><td><span class="text-bold">Cognome:</span></td><td><?php echo $row['cognome']?></td></tr>
            <tr><td><span class="text-bold">Indirizzo:</span></td><td><?php echo $row['indirizzo']?></td></tr>
            <tr><td><span class="text-bold">CAP:</span></td><td><?php echo $row['cap']?></td></tr>
            <tr><td><span class="text-bold">Città:</span></td><td><?php echo $row['citta']?></td></tr>
            </table>
            <?php 
					$peopleSelectedId= $row['id'];
				} 
			}
			$conn->close();
			?>
        </div>
        </p>
        
        <div class="center-align">
        	<table class="table">
            <tr>
                <td>
                <form method="post" action="/studio_medico/anagrafica_edit.php">
                    <input type="hidden" name="peopleSelectedId" value="<? echo $peopleSelectedId ?>">
                    <input type="hidden" name="peopleName" value="<? echo $peopleName ?>">
                    <input type="hidden" name="peopleSurname" value="<? echo $peopleSurname ?>">
                    <button type="submit" class="btn btn-default">Modifica Scheda</button>
                </form>
                </td>
                <td>
                <form method="post" action="/studio_medico/referti_nuovo.php">
                    <input type="hidden" name="peopleSelectedId" value="<? echo $peopleSelectedId ?>">
                    <?php if ($tipo=="P") {?>
                    	<button type="submit" class="btn btn-default">Nuovo Referto</button>
                    <?php }  else { ?>
                    	<button type="submit" class="btn btn-default" disabled="disabled">Nuovo Referto</button>
                    <?php } ?>
                </form>
                </td>
                <td>
                <form method="post" action="/studio_medico/sale_richiama1.php">
                    <input type="hidden" name="data_sheet" value="<? echo date('d-m-Y') ?>">
                    <input type="hidden" name="peopleSelectedId" value="<? echo $peopleSelectedId ?>">
                    <input type="hidden" name="peopleName" value="<? echo $peopleName ?>">
                    <input type="hidden" name="peopleSurname" value="<? echo $peopleSurname ?>">
                    <?php if ($tipo=="P") {?>
                    	<button type="submit" class="btn btn-default" style="width:162px">Nuovo Appuntamento</button>
                    <?php }  else { ?>
                    	<button type="submit" class="btn btn-default" disabled="disabled" style="width:162px">Nuovo Appuntamento</button>
                    <?php } ?>
                </form>
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                <form method="post" action="/studio_medico/referti_mostra.php">
                    <input type="hidden" name="peopleSelectedId" value="<? echo $peopleSelectedId ?>">
                    <input type="hidden" name="peopleName" value="<? echo $peopleName ?>">
                    <input type="hidden" name="peopleSurname" value="<? echo $peopleSurname ?>">
                    <?php if ($tipo=="P") {?>
                    	<button type="submit" class="btn btn-default">Mostra Referti</button>
                    <?php }  else { ?>
                    	<button type="submit" class="btn btn-default" disabled="disabled">Mostra Referti</button>
                    <?php } ?>
                </form> 
                </td>
                <td>
                <form method="post" action="/studio_medico/appuntamenti_lista.php">
                	<input type="hidden" name="peopleType" value="<? echo $tipo ?>">
                    <input type="hidden" name="peopleSelectedId" value="<? echo $peopleSelectedId ?>">
                    <input type="hidden" name="peopleName" value="<? echo $peopleName ?>">
                    <input type="hidden" name="peopleSurname" value="<? echo $peopleSurname ?>">
                    <button type="submit" class="btn btn-default" style="width:162px">Mostra Appuntamenti</button>
                </form>
                </td>
            </tr>
            <?php if ($tipo=="T") {?>
            <tr>
            	<td>
                </td>
                <td>
                </td>
                <td>
                	<form method="post" action="/studio_medico/orari_modifica.php">
                	<input type="hidden" name="peopleType" value="<? echo $tipo ?>">
                    <input type="hidden" name="peopleSelectedId" value="<? echo $peopleSelectedId ?>">
                    <input type="hidden" name="peopleName" value="<? echo $peopleName ?>">
                    <input type="hidden" name="peopleSurname" value="<? echo $peopleSurname ?>">
                    <button type="submit" class="btn btn-default" style="width:162px">Impostazioni Orari</button>
                </form>
                </td>
            </tr>
            <?php } ?>
            </table>
        </div>
    </div><!-- /.container -->

</body>
</html>