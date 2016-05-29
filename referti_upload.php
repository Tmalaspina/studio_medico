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
        <?php  require("require/bodyHeader.php");?>
        <p class="lead">
		<?php
            $target_dir = "referti/". $_POST['peopleSelectedId'] . "/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {?>
                    <span class="text-success text-bold">Il file è un immagine - <?php echo $check["mime"] ?>.</span><br> <?php
                    $uploadOk = 1;
                } else {?>
                    <span class="text-danger text-bold">Il file non è un immagine.</span><br> <?php
                    $uploadOk = 0;
                }
            }
            // Check if file already exists
            if (file_exists($target_file)) { ?>
                <span class="text-danger text-bold">File già esistente.</span><br> <?php
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) { ?>
                <span class="text-danger text-bold">File non caricato perché troppo grande.</span><br> <?php
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) { ?>
                <span class="text-danger text-bold">Tipi di file caricabili: JPG, JPEG, PNG & GIF.</span><br> <?php
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) { ?>
                <span class="text-danger text-bold">File non caricato.</span><br> <?php
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					updateDb($_POST['nomeReferto'], $target_file);
                    echo "<span class='text-success text-bold'>Il file ". basename( $_FILES["fileToUpload"]["name"]). " è stato caricato.</span>";
                } else {?>
                    <span class="text-danger text-bold">Errore durante il caricamento del file.</span><br> <?php
                }
            }
			
			function updateDb($nome, $nome_file) {
				global $db_server, $db_port, $db_login, $db_password, $db_dbName;
				
				// Create connection
				$conn = new mysqli("$db_server:$db_port", $db_login, $db_password, $db_dbName);
				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				} 
				
				$sql= "SELECT max(id) as id FROM referti";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
                    $newId = $row['id'] +1;
				
					$sql = "INSERT INTO referti (id, id_anagrafica, data, nome, nome_file)
						VALUES ('". $newId . "','" . $_POST['peopleSelectedId'] . "', CURDATE(), '" . $nome . "','" . $nome_file . "')";
				
					if ($conn->query($sql) === TRUE) { ?>
						<span class="text-success text-bold">Nuovo referto creato correttamente</span><br> <?php
					} else {
						echo "<span class='text-danger text-bold'>Error: " . $sql . "</span><br>" . $conn->error;
					}
				}
				$conn->close();
				
			}
			
            ?>
        </p>
      	<form method="post" action="anagrafica_showSingle.php">
        	<input type="hidden" name="peopleSelectedId" id="peopleSelectedId" value=<?php echo "'" . $_POST['peopleSelectedId'] . "'"?>>
            <div class="right-align"><button type="submit" class="btn btn-default">Vai alla Scheda</button></div>
        </form>

    </div><!-- /.container -->

</body>
</html>