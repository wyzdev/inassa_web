  $(document).ready(function() {
      $('#example').DataTable( {
          "language": {
              "search": "Rechercher : ",
              "lengthMenu": "Afficher _MENU_",
              "zeroRecords": "Rien n'a été trouvé - désolé",
              "info": "Page _PAGE_ sur _PAGES_",
              "infoEmpty": "Aucune correspondance n'a été trouvé ",
              "infoFiltered": "(filtré parmi _MAX_ éléments)",
              "paginate": {
                  "previous": "Page précédente",
                  "next": "Page suivante"
              }
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