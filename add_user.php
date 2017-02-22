<!DOCTYPE html>
<html>
	<head>
	    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
	    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css">
	    <link rel="stylesheet" type="text/css" href="css/navbar.css">
	    <link rel="stylesheet" type="text/css" href="css/add_user.css">
	    <link rel="stylesheet" type="text/css" href="css/login_form.css">
    	<link rel="stylesheet" type="text/css" href="bootstrap/css/dataTablesbootstrap.min.css">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>INASSA - Ajouter un utilisateur</title>
	</head>

	<body>
		<?php include("includes/navbar.php"); ?>

		<div class="container-fluid">
			<div class="row">
				<div class=" col-md-4 vertical-center">
			        <div class="col-sm-10 col-md-10 col-md-offset-1">
			            <div class="account-wall">
			            	<h3 class="center">Ajouter un nouvel utilisateur</h3>
			                <form class="form-signin" method = "post" action = "/inassa_web/accueil.php">
			                <input type="text" class="form-control margin-10" placeholder="Nom">
			                <input type="text" class="form-control margin-10" placeholder="Prenom">
			                <input type="text" class="form-control margin-10" placeholder="Nom d'utilisateur">
			                <div class="check-container"">
			                	<input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Admin</label>
			                </div>
			                
			                <a href="accueil.php">
			                	<button class="btn btn-lg btn-primary btn-block" type="submit">
			                    Enregistrer</button>
			                </a>
			                </form>
			            </div>
			        </div>
				</div>


				<div class="col-md-8  table-responsive">
					<?php include("includes/tableau_user.php") ?>
				</div>
		    </div>
		</div>


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