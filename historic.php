<!DOCTYPE html>
<html>
	<head>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css">
		<title>INASSA - Historique global</title>
	</head>

	<body>
		<!-- Espace NAVBAR -->
    	<?php include("includes/navbar.php"); ?>
    	<!-- Espace pour le tableau "HISTORIQUE GLOBAL" -->
    	
	    <!-- Espace FOOTER -->
	    <?php include("includes/footer.php"); ?>
	</body>

	  <script type="text/javascript" src="js/jquery.min.js"></script>
	  <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
</html>


<script type="text/javascript">
  $(function() {
      $(".nav li").click(function() {
          $(".nav li").removeClass('active');
          setTimeout(function() {
              var page = $.QueryString("page");
              $(".nav li:eq(" + page + ")").addClass("active");
          }, 300);

      });
  });
</script>