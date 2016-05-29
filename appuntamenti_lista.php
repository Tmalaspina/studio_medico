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
        <?php  
		$h2="Storico appuntamenti di " . $_POST['peopleName'] . " " . $_POST['peopleSurname'];
		require("require/bodyHeader.php");?>
        <p class="lead">
        <?php
			// Create connection
			$conn = new mysqli("$db_server:$db_port", $db_login, $db_password, $db_dbName);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 
			if ($_POST['peopleType']== "T")
			$sql= "select * from (SELECT data,duration,s.name as nome_evento, s.desc as descrizione_evento, s.nome as nome_sala,anagrafica.nome as nome_terapista,cognome as cognome_terapista,id_paziente from (
				SELECT * from (
				SELECT DATE_FORMAT(event.hourstart,'%d-%m-%Y %H:%i')as data ,duration,name,event.desc,id_sala,id_terapista,id_paziente  
				FROM event inner join appuntamenti on event.id=appuntamenti.id_evento
				WHERE appuntamenti.id_terapista='" . $_POST['peopleSelectedId']. "') as e inner join sale on e.id_sala=sale.id) as s inner join anagrafica on s.id_terapista=anagrafica.id) as a inner join anagrafica on a.id_paziente=anagrafica.id ORDER BY data desc";
			else
				$sql= "SELECT data,duration,s.name as nome_evento, s.desc as descrizione_evento, s.nome as nome_sala,anagrafica.nome as nome_terapista,cognome as cognome_terapista from (
				SELECT * from (
				SELECT DATE_FORMAT(event.hourstart,'%d-%m-%Y %H:%i')as data ,duration,name,event.desc,id_sala,id_terapista  
				FROM event inner join appuntamenti on event.id=appuntamenti.id_evento
				WHERE appuntamenti.id_paziente='" . $_POST['peopleSelectedId'] . "') as e inner join sale on e.id_sala=sale.id) as s inner join anagrafica on s.id_terapista=anagrafica.id ORDER BY data desc";
			//$sql = "SELECT DATE_FORMAT(event.date,'%d-%m-%Y') as data, FROM eventi inner join appuntamenti on eventi.id_appuntamento=appuntamenti.id WHERE id_paziente='" . $_POST['peopleSelectedId'] ."' ORDER BY data desc";
			$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
				// output data of each row
				?>
				<table class="table table-bordered table-striped">
                <thead class="text-bold">
                <tr>
                	<td>Data Appuntamento</td>
                    <td>Nome Appuntamento</td>
                    <td>Descrizione Appuntamento</td>
                    <td>Nome Sala</td>
                     <?php if ($_POST['peopleType']=='P') {?>
                    <td>Nome Terapista</td>
                     <?php } else { ?>
                     <td>Nome Paziente</td>
                     <td>Cognome Paziente</td>
                      <?php } ?>
                </tr>
                </thead><tbody>
				<?php 
				while($row = $result->fetch_assoc()) {
					?><tr>
                    	<td><?php echo $row["data"] ?></td>
                        <td><?php echo $row["nome_evento"] ?></td>
                        <td><?php echo $row["descrizione_evento"] ?></td>
         				<td><?php echo $row["nome_sala"] ?></td>
                        <?php if ($_POST['peopleType']=='P') {?>
                        <td><?php echo $row["nome_terapista"] ?></td>
                        <?php } else { ?>
                        <td><?php echo $row["nome"] ?></td>
                        <td><?php echo $row["cognome"] ?></td>
                        <?php } ?>
                    </tr> <?php
				} ?> </tbody>
                </table>
                <?php
			} else {?>
				<div>
                	<span class="text-danger text-bold">Nessun appuntamento registrato</span>
                </div>
			<?php }
			$conn->close();
        ?>
        </p>
        <form method="post" action="anagrafica_showSingle.php">
        	<input type="hidden" name="peopleSelectedId" id="peopleSelectedId" value=<?php echo "'" . $_POST['peopleSelectedId'] . "'"?>>
            <div class="right-align">
            	<button type="submit" class="btn btn-default" style="margin: 30px">Vai alla Scheda</button>
            </div>
        </form>
        </p>
    </div><!-- /.container -->

</body>
</html>