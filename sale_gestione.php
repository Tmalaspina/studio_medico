<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Studio Medico</title>
<link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
<link href="style.css" rel="stylesheet">
<script>
function setupId(id, nome) {
	$("#id_sala").val(id);
	$("#nome_sala").attr("placeholder", nome);
}
</script>
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
			$h2="Elenco sale";
			require("require/bodyHeader.php");
		?>
        <p class="lead">
        <?php
			// Create connection
			$conn = new mysqli("$db_server:$db_port", $db_login, $db_password, $db_dbName);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 
			
			$sql = "SELECT * FROM sale ORDER BY nome";
			$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
				// output data of each row
				?>
                <table class="table table-bordered table-hover table-striped">
                <thead>
                	<tr class="text-bold"><td>Nome</td><td style="width: 90px"></td></tr>
                </thead>
                <tbody>
                <?php
				while($row = $result->fetch_assoc()) { ?>
					<tr><td><?php echo $row["nome"] ?></td><td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" onClick="setupId(<?php echo $row["id"]?>, '<?php echo $row["nome"]?>')">Rinomina</button></td></tr>
				<?php 
				}
				?>
                </tbody>
                </table>
                <?php
			} else {
				echo "0 results";
			}
			$conn->close();
		?>
        <div class="right-align">
        	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal_new" style="width: 85px; margin-right: 9px;">Nuova</button>
        </div>
        </p>
    </div><!-- /.container -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Chiudi"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Rinomina sala</h4>
      </div>
      <form method="post" action="sale_rinomina.php">
          <div class="modal-body">
          	<input type="hidden" name="id_sala" id="id_sala" value="">
            <label for="nome_sala">
            	Nuovo nome:
            	<input type="text" name="nome_sala" id="nome_sala" value="" class="form-control" placeholder="Nuovo nome">
            </label>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
            <button type="submit" class="btn btn-primary">OK</button>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal new -->
<div class="modal fade" id="myModal_new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Chiudi"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuova sala</h4>
      </div>
      <form method="post" action="sale_nuova.php">
          <div class="modal-body">
            <label for="nome_sala">
            	Nuova sala:
            	<input type="text" name="nome_sala" id="nome_sala" value="" class="form-control" placeholder="Nuova sala">
            </label>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
            <button type="submit" class="btn btn-primary">OK</button>
          </div>
      </form>
    </div>
  </div>
</div>


</body>
</html>