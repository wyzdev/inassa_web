  $(document).ready(function() {
      $('#example').DataTable( {
          "language": {
              "search": "Rechercher : ",
              "lengthMenu": "Afficher _MENU_",
              "zeroRecords": "Rien n\'a ete trouve - desole",
              "info": "Page _PAGE_ sur _PAGES_",
              "infoEmpty": "Aucune correspondance n'a ete trouve",
              "infoFiltered": "(filtre parmi _MAX_ elements)"
          },
          "lengthMenu": [
              [
                  -1, 5, 10, 25, 50
              ],
              [
                  'Tous', 5, 10, 25, 50
              ]
          ]
      }
      );
  } );