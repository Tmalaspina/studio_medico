<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
          <li role="presentation dropdown"><a class="navbar-brand dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" href="#">Studio Medico<span class="caret"></span></a>
          <ul class="dropdown-menu">
          	<li><a href="/studio_medico/settings.php">Impostazioni</a></li>
          </ul>
          </li>
          <?php if ($nav_active=="Home") { ?>
            <li role="presentation" class="dropdown active">
            	<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" href="/studio_medico/index.php">Home
                	<span class="caret"></span>
                </a>
           <?php } else { ?>
            <li role="presentation" class="dropdown">
            	<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" href="/studio_medico/index.php">Home
                	<span class="caret"></span>
                </a>
           <?php } ?>
               <ul class="dropdown-menu">
               		  <li><a href="/studio_medico/index.php">Start</a></li>
                      <li><a href="/studio_medico/sale_richiama1.php">Calendario</a></li>
               </ul>
           </li>
           <?php if ($nav_active=="Anagrafica") { ?>
            <li role="presentation" class="dropdown active">
            	<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" href="/studio_medico/anagrafica.php">Anagrafica
                	<span class="caret"></span>
                </a>
           <?php } else { ?>
            <li role="presentation" class="dropdown">
            	<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" href="/studio_medico/anagrafica.php">Anagrafica
                	<span class="caret"></span>
                </a>
           <?php } ?>
            	<ul class="dropdown-menu">
                  <li><a href="/studio_medico/anagrafica.php">Nuovo Contatto</a></li>
                  <li><a href="/studio_medico/anagrafica_recall.php">Richiama Contatto</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="/studio_medico/sale_gestione.php">Gestisci Sale</a></li>
                </ul>
            </li>
            <li><a href="#contact">Contatti</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
