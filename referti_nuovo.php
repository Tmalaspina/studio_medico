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
            <form action="referti_upload.php" method="post" enctype="multipart/form-data">
            	<input type="hidden" name="peopleSelectedId" id="peopleSelectedId" value=<?php echo "'" . $_POST['peopleSelectedId'] . "'"?>>
            	<label for="nomeReferto">
                Nome del Referto
                <input type="text" name="nomeReferto" id="nomeReferto" class="form-control" placeholder="Nome del Referto" style="padding: 15px; margin: 15px">
                </label><br>
                <label for="fileToUpload">
                Seleziona il file da caricare
                <input type="file" name="fileToUpload" id="fileToUpload" style="padding: 15px">
                </label>
                <input type="submit" value="Upload File" name="submit" class="btn btn-default">
            </form>
        </p>
    </div><!-- /.container -->

</body>
</html>