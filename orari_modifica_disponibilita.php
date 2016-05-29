<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Studio Medico</title>
<link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
<link href="style.css" rel="stylesheet">
<script>
function onTerapistChange() {
		$("#id_terapista_sel").val(
			$("#id_terapista").val());
		$("#nome").val(
			$("#id_terapista option:selected").text());
}
</script>
</head>

<body>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
    
    <?php $nav_active="Anagrafica" ?>
    <?php require ("require/nav.php");?>
    <?php require ("require/db_settings.php");?>
	<?php $eng_ita_translate= array(
		Monday => 'lunedì',
		Tuesday => 'martedì',
		Wednesday => 'mercoledì',
		Thursday => 'giovedì',
		Friday => 'venerdì',
		Saturday => 'sabato',
	); ?>
    <div class="container">
        <?php  
		$h2="Orari del giorno ". $_POST['data_sheet'];
		if ($_POST['nome'] != '')
			$h2 = $h2 . " per " . $_POST['nome'];
		require("require/bodyHeader.php");?>
        <p class="lead">
      <?php
				// Create connection
				$conn = new mysqli("$db_server:$db_port", $db_login, $db_password, $db_dbName);
				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				} 
				
				$sql = 'select * from anagrafica where tipo="T" order by cognome, nome';
						
				$result = $conn->query($sql);
				if ($result->num_rows > 0) { ?>
            <form method="post" action="orari_modifica_disponibilita.php">
            <label>Terapista
                <select class="form-control" name="id_terapista" id="id_terapista" onChange="onTerapistChange()">
					<option value="" disabled="disabled" selected>Scegli...</option>
					<?php while($row = $result->fetch_assoc()) {?>
                      <option value="<?php echo $row['id'] ?>" ><?php echo $row['nome'] ?></option>
                    <?php } ?>
                </select>
            </label>
            <input type="hidden" name="id_terapista_sel" id="id_terapista_sel" value="<?php echo $_POST['id_terapista_sel']?>">
            <input type="hidden" name="nome" id="nome" value="<?php echo $_POST['nome']?>">
            <input type="hidden" name="data_sheet" id="datepicker3" readonly  class="form-control clsDatePicker" value=<?php echo '"' . $_POST['data_sheet'] . '"' ?>>
            <button type="submit" class="btn btn-default">Seleziona</button>
            </form>
			<?php
					 } else { ?>
				<br><span class="text-danger text-bold">Nessun record trovato</span> <?php $conn->error;
			}
			
			$conn->close();
				
		
			if (strlen($_POST['id_terapista_sel'])>0) {
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
			
			$sql = 'select * from disponibilita_orari where id_terapista="' . $_POST['id_terapista_sel'] .'" and data="' . $ds_Ymd .  '"';
	
			$result = $conn->query($sql);
			if ($result->num_rows > 0) { ?>
            	<form method="post" action="orari_doModifica_disponibilita.php">
                <input type="hidden" name="data_sheet" id="datepicker3" readonly class="form-control clsDatePicker" value=<?php echo '"' . $_POST['data_sheet'] . '"' ?>>
                <input type="hidden" name="peopleSelectedId" id="peopleSelectedId" value=<?php echo '"' . $_POST['id_terapista_sel'] . '"' ?> >
                <table class="table table-striped">
				<?php while($row = $result->fetch_assoc()) {
			?>
            	<tr>
            	<td><div><strong><?php echo $eng_ita_translate[$row['giorno']] ?></strong></div></td><td></td>
                </tr>
                <tr>
            	<td><label> 
                <?php echo "dalle ore:" ?>
                <input type="text" name=<?php echo '"dalleore"' ?> id=<?php echo '"dalleore"' ?> value=<?php echo '"' . substr($row['dalleore'],0,5) . '"'?> placeholder= "dalle ore" class="form-control">
                </label></td>
                <td><label> 
                <?php echo "alle ore:" ?>
                <input type="text" name=<?php echo '"alleore"' ?> id=<?php echo '"alleore"' ?> value=<?php echo '"' . substr($row['alleore'],0,5) . '"'?> placeholder= "alle ore" class="form-control">
                </label></td>
                </tr>
            <?php } ?>
            	
            	</table>
                <div class="right-align" ><button type="submit" class="btn btn-default">Modifica</button></div>
            </form>
            <?php } 
			$conn->close();
			}
			?>
        </p>
      

    </div><!-- /.container -->

</body>
</html>