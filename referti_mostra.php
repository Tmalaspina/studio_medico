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
        <?php  
		$h2= "Referti per " . $_POST['peopleName'] . ' ' .$_POST['peopleSurname'];
		require("require/bodyHeader.php");?>
        <p class="lead">
		<?php
			// Create connection
			$conn = new mysqli("$db_server:$db_port", $db_login, $db_password, $db_dbName);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 
			
			$sql = "SELECT DATE_FORMAT(data,'%d-%m-%Y') as data,nome,nome_file FROM referti WHERE id_anagrafica='" . $_POST['peopleSelectedId'] ."' ORDER BY data";
			$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
				// output data of each row
				?>
				<table class="table table-bordered table-striped">
                <thead class="text-bold">
                <tr>
                <td>Data Referto</td><td>Nome</td><td>File (click per scaricare)</td>
                </tr>
                </thead><tbody>
				<?php 
				while($row = $result->fetch_assoc()) {
					?><tr><td><?php echo $row["data"] ?></td><td><?php echo $row["nome"] ?></td><td><a href="<?php echo $row["nome_file"] ?>" download><img src="<?php echo $row["nome_file"] ?>" style="max-width: 300px; max-height:300px"></a></td></tr> <?php
				} ?> </tbody>
                </table>
                <?php
			} else { ?>
				<span class="text-danger text-bold">Nessun referto per questo paziente</span> <?php
			}
			$conn->close();
        ?>
        </p>
        <form method="post" action="anagrafica_showSingle.php">
        	<input type="hidden" name="peopleSelectedId" id="peopleSelectedId" value=<?php echo "'" . $_POST['peopleSelectedId'] . "'"?>>
            <div class="right-align"><button type="submit" class="btn btn-default" style="margin: 30px">Vai alla Scheda</button></div>
        </form>
    </div><!-- /.container -->

</body>
</html>