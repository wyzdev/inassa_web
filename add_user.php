<!DOCTYPE html>
<html>
	<head>
	    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
	    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css">
	    <link rel="stylesheet" type="text/css" href="css/navbar.css">
	    <link rel="stylesheet" type="text/css" href="css/add_user.css">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>INASSA - Ajouter un utilisateur</title>
	</head>

	<body>
		<div class="container">
			 <div class="row">
		        <div class="col-sm-6 col-md-4 col-md-offset-4">
		            <div class="account-wall">
		                <form class="form-signin" method = "post" action = "/inassa_web/accueil.php">
		                <input type="text" class="form-control" placeholder="Nom d'utilisateur">
		                <input type="password" class="form-control" placeholder="Mot de passe">
		                <a href="accueil.php">
		                	<button class="btn btn-lg btn-primary btn-block" type="submit">
		                    Enregistrer</button>
		                </a>
		                </form>
		            </div>
		        </div>
		    </div>
		</div>

	</body>
</html>