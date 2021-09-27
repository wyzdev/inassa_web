  $(document).ready(function() {
      $('#example').DataTable( {
        "order" : [],
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

  $(document).ready(function() {
      $('#example1').DataTable( {
          "order" : [],
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
          ],
          responsive: true,
          orderCellsTop: true,
          initComplete: function () {
              this.api().columns().every( function () {
                  var column = this;
                  var select = $('<select><option value=""></option></select>')
                      .appendTo( $(column.header()).empty() )
                      .on( 'change', function () {
                          var val = $.fn.dataTable.util.escapeRegex(
                              $(this).val()
                          );

                          column
                              .search( val ? '^'+val+'$' : '', true, false )
                              .draw();
                      } );

                  column.data().unique().sort().each( function ( d, j ) {
                      select.append( '<option value="'+d+'">'+d+'</option>' )
                  } );
              } );
          }
      } );
  } );

  $(document).ready(function() {
      $('#example2').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax": window.location.protocol + "//" + window.location.host + "/" + location.pathname.split('/')[1] + "/logs/add"
      } );
  } );