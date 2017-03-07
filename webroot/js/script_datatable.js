  $(document).ready(function() {
      $('#example').DataTable( {
          "language": {
              "search": "Rechercher : ",
              "lengthMenu": "Afficher _MENU_ par page",
              "zeroRecords": "Nothing found - sorry",
              "info": "Showing page _PAGE_ of _PAGES_",
              "infoEmpty": "No records available",
              "infoFiltered": "(filtered from _MAX_ total records)"
          }
      } );
  } );