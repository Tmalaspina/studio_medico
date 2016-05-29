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
		$h2="Orari di default per " . $_POST['peopleName'];
		require("require/bodyHeader.php");?>
        <p class="lead">
        <?php
			// Create connection
			$conn = new mysqli("$db_server:$db_port", $db_login, $db_password, $db_dbName);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 
			
			$sql = 'select * from template_orari where id_terapista="' . $_POST['peopleSelectedId'] .'" order by ordine_giorno';
					
			$result = $conn->query($sql);
			if ($result->num_rows > 0) { ?>
            	<form method="post" action="orari_doEdit.php">
                <input type="hidden" name="peopleSelectedId" id="peopleSelectedId" value=<?php echo '"' . $_POST['peopleSelectedId'] . '"' ?> >
                <table class="table table-striped">
				<?php while($row = $result->fetch_assoc()) {
			?>
            	<tr>
            	<td><div><strong><?php echo $eng_ita_translate[$row['giorno']] ?></strong></div></td><td></td>
                </tr>
                <tr>
            	<td><label> 
                <?php echo "dalle ore:" ?>
                <input type="text" name=<?php echo '"' . substr($row['giorno'],0,3) . '_dalleore"' ?> id=<?php echo '"' . substr($row['giorno'],0,3) . '_dalleore"' ?> value=<?php echo '"' . substr($row['dalleore'],0,5) . '"'?> placeholder= "dalle ore" class="form-control">
                </label></td>
                <td><label> 
                <?php echo "alle ore:" ?>
                <input type="text" name=<?php echo '"' . substr($row['giorno'],0,3) . '_alleore"' ?> id=<?php echo '"' . substr($row['giorno'],0,3) . '_alleore"' ?> value=<?php echo '"' . substr($row['alleore'],0,5) . '"'?> placeholder= "alle ore" class="form-control">
                </label></td>
                </tr>
            <?php } ?>
            	
            	</table>
                <div class="right-align" ><button type="submit" class="btn btn-default">Modifica</button></div>
            </form>
            <?php } 
			$conn->close()
			?>
        </p>
      

    </div><!-- /.container -->

</body>
</html>