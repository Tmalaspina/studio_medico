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

    <div class="container">
        <?php  require("require/bodyHeader.php");?>
        <p class="lead">
        	Ricerca per Nome e/o Cognome
        	<form method="post" action="/studio_medico/anagrafica_recallShow.php">
            	<div class="form-group">
    				<label for="nome">Nome e/o Cognome</label>
    				<input type="text" name="nomeeocognome" class="form-control" id="nomeeocognome" placeholder="Nome e/o cognome">
  				</div>
                <div class="right-align">
                	<button type="submit" class="btn btn-default">Cerca</button>
                </div>
            </form>
        </p>
    </div><!-- /.container -->

</body>
</html>