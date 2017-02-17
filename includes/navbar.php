
  <nav class="navbar navbar-default" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">INASSA</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" >
      <ul class="nav navbar-nav" id="menu">
        <li class="active"><a href="accueil.php">Accueil</a></li>
        <li><a href="historic.php">Historique global</a></li>
        
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding: 5%">
            <img src="img/logo_inassa.png" height="40"  style="border-radius: 50%; border: 1px green solid;margin-right:5px;">
            <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#">Ajouter un utilisateur</a></li>
            <li class="divider"></li>
            <li><a href="index.php">Deconnexion</a></li>
          </ul>
        </li>
      </ul>
      <div class="col-sm-3 col-md-3 navbar-right">
          <form class="navbar-form" role="search">
          <div class="input-group">
              <input type="text" class="form-control" placeholder="Rechercher un client" name="q">
              <div class="input-group-btn">
                  <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
              </div>
          </div>
          </form>
      </div>
    </div><!-- /.navbar-collapse -->
  </nav>