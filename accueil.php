<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css">
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <link rel="stylesheet" type="text/css" href="css/accueil.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INASSA - Accueil</title>
  </head>
  
  <body>
    <?php include("includes/navbar.php"); ?>
    <!-- Corps de la page -->
    <div class="container">
      <!-- <p class="text-center">
        Recherchez le client pour activer ou désactiver sa carte ...
      </p> -->
      <div class="info_client container-fluid">
        <h3 class="title_search margin-bottom-20">Recherche Active</h3>
        <p class="info-container">
          <span class="indicatif">Client</span>
          <span class="deux-point">:</span>
          <span class="result">John DOE</span>
          <br />
          <span class="indicatif">Date de naissance</span>
          <span class="deux-point">:</span>
          <span class="result">07 / 04 / 1973</span>
          <div class="status-carte center-horizontal margin-bottom-20">
            <span class="status">Carte Active : 1Z3E4RTFG</span>
          </div>
        </p>

      </div>
      <div class="center-horizontal container-fluid center-horizontal margin-10">
        <a class="btn btn-default btn-primary col-xs-12 col-md-4  col-md-offset-4 margin-10 padding-10">Desactiver la carte</a>
        <a class="btn btn-default btn-primary col-xs-12 col-md-4  col-md-offset-4 margin-10 padding-10">Activer la carte</a>
        <a class="btn btn-default btn-primary col-xs-12 col-md-4  col-md-offset-4 margin-10 padding-10">Historique du client</a>
      </div>  
    </div>

    <!-- Espace FOOTER -->
    <?php include("includes/footer.php"); ?>
  </body>

  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
</html>