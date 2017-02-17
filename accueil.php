<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css">
    <link rel="stylesheet" type="text/css" href="css/vertical_center.css">
    <title>INASSA - Accueil</title>
  </head>
  
  <body>
    <?php include("includes/navbar.php"); ?>
    <!-- Corps de la page -->
    <div class="container">
      <p class="text-center">
        Recherchez le client pour activer ou désactiver sa carte ...
      </p>
    </div>

    <!-- Espace FOOTER -->
    <?php include("includes/footer.php"); ?>
  </body>

  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
</html>

<!-- <script type="text/javascript">
  $('ul#menu li').click(function(e) {
      $('.nav li.active').removeClass('active');
      var $this = $(this);
      $this.addClass('active');
      e.preventDefault();
  });
</script> -->
<!-- <script type="text/javascript">
  $(function() {
      $(".nav li").click(function() {
          $(".nav li").removeClass('active');
          setTimeout(function() {
              var page = $.QueryString("page");
              $(".nav li:eq(" + page + ")").addClass("active");
          }, 3);

      });
  });
</script> -->