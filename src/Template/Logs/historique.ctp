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

<!--Block contenant la recherche de l'historique d'un client-->


<div class="container">
    <div class="row">
        <div id="" class="">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-inline" role="form" method="post" accept-charset="utf-8"
                          action="historique">
                        <div class="form-group col-md-2 col-md-offset-1 col-xs-10 col-xs-offset-1">
                            <?= $this->Form->input("first_name", array("class" => "form-control margin-10", "label" => false, "placeholder" => "Prénom")) ?>
                        </div> <!-- form group [rows] -->
                        <div class="form-group col-md-2 col-md-offset-1 col-xs-10 col-xs-offset-1">
                            <?= $this->Form->input("last_name", array("class" => "form-control margin-10", "label" => false, "placeholder" => "NOM")) ?>
                        </div><!-- form group [search] -->
                        <div class="form-group col-md-2 col-md-offset-1 col-xs-10 col-xs-offset-1" style="margin-top: 5px;">
                            <div>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    <input name="dob" id="dob" type="text" class="form-control  datepicker"
                                           placeholder="Date de naissance">
                                </div>
                            </div>
                        </div> <!-- form group [order by] -->
                        <div class="form-group  col-md-2 col-md-offset-1 col-xs-10 col-xs-offset-1">
                            <button type="submit" class="btn btn-default filter-col">
                                <span class="glyphicon glyphicon-search"></span> Rechercher
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Block contenant un exemple de tableau -->
<div class="container-fluid  table-responsive">
    <table id="example" class="table table-striped table-hover table-condensed" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Institution</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Institution</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
        </tfoot>
        <tbody>
        <?php foreach ($logs as $log): ?>
            <tr>
                <td><?= $log->last_name ?></td>
                <td><?= $log->first_name ?></td>
                <td><?= $log->institution ?></td><!-- 
                ////////////////////////////////////////////////// -->
                <?php

                $timestamp = strtotime($log->date);
                setlocale (LC_TIME, 'fr_FR.utf8','fra');
                ?><!--
                ///////////////////////////////////////////////// -->
                <td><?= strftime( "%d %B %Y, %H:%M", $timestamp ) ; ?></td>
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

<!--/////////////////////////////// LOADER /////////////////////////////////////////-->
<div id="content_loader" style="background: #fff; height: 100vh;  top:0px; left: 0px; right: 0px; position: absolute; z-index: 2;">
    <div id="loader"></div>
</div>
