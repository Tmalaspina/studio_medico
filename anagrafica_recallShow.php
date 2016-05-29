<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Studio Medico</title>
<link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
<link href="style.css" rel="stylesheet">
<script>
function onRadioSelected(i) {
	$('#peopleSelectedId').val(i);
}

function selectRadio(i,radio) {
	$('#optionsRadios_' + radio).prop("checked",true);
	onRadioSelected(i);
}
</script>
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
        	Ricerca per Nome e/o Cognome: Risultati
        	<?php
				// Create connection
				$conn = new mysqli("$db_server:$db_port", $db_login, $db_password, $db_dbName);
				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				} 
				
				$sql = 'select * from (select id, concat(nome,cognome) as c, nome, cognome, indirizzo, cap, citta from anagrafica) as z
						where c like "%' . $_POST['nomeeocognome'] . '%"';
						
				$result = $conn->query($sql);
				if ($result->num_rows > 0) { ?>
                	<br>
					<span class="text-success text-bold">Record trovati: <?php echo $result->num_rows ?></span><br>
                    <div class="left-align">
                    <form method="post" action="/studio_medico/anagrafica_showSingle.php">
                    		<input type="hidden" name="peopleSelectedId" id="peopleSelectedId">
                        	<table class="table table-bordered table-striped table-hover">
                            	<thead>
                                <tr>
                                    <td></td>
                                	<td><span class="text-bold">Nome</span></td><td><span class="text-bold">Cognome</span></td>
                                    <td><span class="text-bold">Indirizzo</span></td><td><span class="text-bold">CAP</span></td><td><span class="text-bold">Città</span></td>
                                </tr>
                                </thead>
                                <tbody>
                    <?php
                    for($i=0;$row = $result->fetch_assoc();$i++) { ?>
                                
                                <tr onclick="<?php echo 'selectRadio('. $row['id'] . ',' . $i .')' ?>">
                                	<td>
                                    	<div class="radio no-margin">
                                          <label>
                                            <input type="radio" name="optionsRadios" id=<?php echo "optionsRadios_" . $i ?>  value=<?php echo "option_" . $i ?> onClick="onRadioSelected(<?php echo $row['id'] ?>)">
                                          </label>
                                        </div>
                                    </td>
                                	<td><?php echo $row['nome']?></td><td><?php echo $row['cognome']?></td><td><?php echo $row['indirizzo']?></td><td><?php echo $row['cap']?></td>
                                    <td><?php echo $row['citta']?></td>
                                </tr>
                                
    				<?php 
					} ?>
                    			</tbody>
                            </table>
                            <div class="right-align">
                            	<button type="submit" class="btn btn-default">Visualizza</button>
                            </div>
                    </form>
                    </div>
               		 <?php 
					 } else { ?>
				<br><span class="text-danger text-bold">Nessun record trovato</span> <?php $conn->error;
			}
			
			$conn->close();
		?>
        </p>
    </div><!-- /.container -->

</body>
</html>