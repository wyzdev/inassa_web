<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css">
		<link rel="stylesheet" type="text/css" href="css/vertical_center.css">
		<link rel="stylesheet" type="text/css" href="css/login_form.css">
		<title>INASSA</title>
	</head>


	<body>
		<div class="container-fluid vertical-center">
			<div class="container">
			    <div class="row">
			        <div class="col-sm-6 col-md-4 col-md-offset-4">
			            <div class="account-wall">
			                <img class="profile-img" src="img/logo_inassa.png"
			                    alt="">
			                <form class="form-signin" method = "post" action = "/inassa_web/accueil.php">
			                <input type="text" class="form-control" placeholder="Nom d'utilisateur">
			                <input type="password" class="form-control" placeholder="Mot de passe">
			                <a href="accueil.php">
			                	<button class="btn btn-lg btn-primary btn-block" type="submit">
			                    Connexion</button>
			                </a>
			                </form>
			            </div>
			        </div>
			    </div>
			</div>
		</div>
	    
	</body>
</html>