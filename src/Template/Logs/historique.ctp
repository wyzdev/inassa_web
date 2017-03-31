<?= $this->assign('title', 'INASSA - Historique'); ?>

<?= $this->start('nom_du_block'); ?>


<?= $this->end(); ?>

<?php //$this->Html->css('nom_du_fichier_css', null, array('inline' => false)); ?>
<?php //$this->Html->script('nom_du_fichier_js', array('inline' => false)); ?>


<?= $this->Html->css('historique'); ?>
<?= $this->Html->css('dataTablesbootstrap.min'); ?>


<!-- fichier javaScript qui vont permettre au datatable de fonctionner correctement -->

<?php //$this->Html->script('jquery.min', array('inline' => false)); ?>
<?php //$this->Html->script('bootstrap', array('inline' => false)); ?>
<?php //$this->Html->script('jquery.dataTables.min', array('inline' => false)); ?>
<?php //$this->Html->script('dataTables.bootstrap.min', array('inline' => false)); ?>


<!--C'est un script qui va nous permettre de faire marcher le datatable  -->

<?php //$this->Html->script('script_datatable', array('inline' => false)); ?>

<!-- Block contenant un exemple de tableau -->
<div class="container-fluid  table-responsive">
    <table id="example" class="table table-striped table-hover table-condensed" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Localisation</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Localisation</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
        </tfoot>
        <tbody>
        <?php foreach ($logs as $log): ?>
            <tr>
                <td><?= $log->last_name ?></td>
                <td><?= $log->first_name ?></td>
                <td><?= $log->postal_address ?></td>
                <td><?= $log->date ?></td>
                <td>
                    <?php
                    if ($log->status)
                        echo "Active";
                    else
                        echo "Inactive"; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>



<?= $this->Html->css('Leaflet/leaflet') ?>
<?= $this->Html->script('Leaflet/leaflet') ?>

<div class="container">
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Position exacte</h4>
                </div>
                <div class="modal-body col-sm-12" id="map-container">
                    <!--Map-->
                    <!--<div id="mapid" style="height: 300px; border: 1px solid green;"></div>-->
                    <!--//Map-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </div>

        </div>
    </div>

</div>