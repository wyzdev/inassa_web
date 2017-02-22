<!DOCTYPE html>
<html>
	<head>

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/historique.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/dataTablesbootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css">
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>INASSA - Historique global</title>
	</head>

	<body>
		<!-- Espace NAVBAR -->
    	<?php include("includes/navbar.php"); ?>

    	<!-- Espace pour le tableau "HISTORIQUE GLOBAL" -->
      <div class="container-fluid  table-responsive">
        <?php include("includes/tableau_historique.php") ?>
      </div>

	    <!-- Espace FOOTER -->
	    <?php include("includes/footer.php"); ?>
	</body>

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="bootstrap/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/dataTables.bootstrap.min.js"></script>
</html>


<script type="text/javascript">
  $(document).ready(function() {
      $('#example').DataTable();
  } );
</script>