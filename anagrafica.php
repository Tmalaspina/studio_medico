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

      <div class="starter-template">
        <h1>Nuova Anagrafica</h1>
        <p class="lead">
        	<form method="post" action="/studio_medico/anagrafica_insert.php">
            <div class="left-align little-padding">
            
              <label class="radio-inline" >
                <input type="radio" name="tipo" id="radioTerapista" value="T" >
           	  <strong>Terapista </strong>
              </label>
            
            
              <label class="radio-inline">
                <input type="radio" name="tipo" id="radioPaziente" value="P" checked>
                <strong>Paziente</strong>
              </label>
            
            </div>
            	<div class="form-group" style="margin-top: 15px">
    				<label for="nome">Nome</label>
    				<input type="text" name="nome" class="form-control" id="nome" placeholder="Nome">
  				</div>
                <div class="form-group">
    				<label for="cognome">Cognome</label>
    				<input type="text" name="cognome" class="form-control" id="cognome" placeholder="Cognome">
  				</div>
                <div class="form-group">
    				<label for="indirizzo">Indirizzo</label>
    				<input type="text" name="indirizzo" class="form-control" id="indirizzo" placeholder="Indirizzo">
  				</div>
                <div class="form-group">
    				<label for="cap">CAP</label>
    				<input type="text" name="cap" class="form-control" id="cap" placeholder="CAP">
  				</div>
                <div class="form-group">
    				<label for="citta">Città</label>
    				<input type="text" name="citta" class="form-control" id="citta" placeholder="Città">
  				</div>
                <div class="right-align">
                	<button type="submit" class="btn btn-default">Inserisci</button>
                </div>
            </form>
        </p>
      </div>

    </div><!-- /.container -->

</body>
</html>