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
                <td><?= $log->institution ?></td>
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