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
    
    <?php $nav_active="Studio Medico" ?>
    <?php require ("nav.php");?>
    <?php require ("db_settings.php");?>

    <div class="container">

      <div class="starter-template">
        <h1>Impostazioni</h1>
        <br>
        	<table class="table table-bordered left-align">
        	<tr><td><span class="text-bold">Login: </span></td><td><?php echo $db_login ?></td></tr>
            <tr><td><span class="text-bold">Password: </span></td><td><?php echo $db_password ?></td>
            <tr><td><span class="text-bold">Server: </span></td><td><?php echo $db_server ?></td></tr>
            <tr><td><span class="text-bold">Port: </span></td><td><?php echo $db_port ?></td></tr>
            <tr><td><span class="text-bold">DB Name: </span></td><td><?php echo $db_dbName ?></td></tr>
            </table>
        
      </div>

    </div><!-- /.container -->

</body>
</html>