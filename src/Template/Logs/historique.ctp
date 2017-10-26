<?= $this->assign('title', 'INASSA - Historique'); ?>

<?= $this->start('nom_du_block'); ?>


<?= $this->end(); ?>



<?= $this->Html->css('historique'); ?>
<?= $this->Html->css('dataTablesbootstrap.min'); ?>

<?php 

$dob_input = (isset($dob)) ? $dob : '';
?>
<div class="container">
    <div class="row">
        <div id="" class="">
            <div class="panel panel-default">
                <div class="panel-body">
                        <?= $this->Form->create("Logs", array('class' => "form-inline")) ?>
                        <div class="form-group col-md-2 col-md-offset-1 col-xs-10 col-xs-offset-1">
                            <?= $this->Form->input("last_name", array("class" => "form-control margin-10", "label" => false, "placeholder" => "NOM")) ?>
                        </div>
                        <div class="form-group col-md-2 col-md-offset-1 col-xs-10 col-xs-offset-1">
                            <?= $this->Form->input("first_name", array("class" => "form-control margin-10", "label" => false, "placeholder" => "Prénom")) ?>
                        </div>
                        <div class="form-group col-md-2 col-md-offset-1 col-xs-10 col-xs-offset-1" style="margin-top: 5px;">
                            <div>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    <input name="dob" id="dob" type="text" class="form-control  datepicker"
                                           placeholder="Date de naissance" value="<?= $dob_input ?>">
                                </div>
                            </div>
                        </div> <!-- form group [order by] -->
                        <div class="form-group  col-md-2 col-md-offset-1 col-xs-10 col-xs-offset-1">
                            <button type="submit" class="btn btn-default filter-col">
                                <span class="glyphicon glyphicon-search"></span> Rechercher
                            </button>
                        </div>
                   <!-- </form>-->
                    <?= $this->Form->end()?>
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
            <th>Source</th>
            <th>Date (jj/mm/aaaa, hh:mn)</th>
            <th>Status</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Institution</th>
            <th>Source</th>
            <th>Date (jj/mm/aaaa, hh:mn)</th>
            <th>Status</th>
        </tr>
        </tfoot>
        <tbody>
        <?php foreach ($logs as $log): ?>
            <tr>
                <td><?= $log->last_name ?></td>
                <td><?= $log->first_name ?></td>
                <td><?= $log->institution ?></td>
                <td><?= $log->doctor_name ?></td><!--
                ////////////////////////////////////////////////// -->
                <?php

                $timestamp = strtotime($log->date);
                setlocale (LC_TIME, 'fr_FR.utf8','fra');
                ?><!--
                ///////////////////////////////////////////////// -->
                <td><?= strftime( "%d/%m/%Y, %H:%M", $timestamp ) ; ?></td>
                <td>
                    <?php
                    if ($log->status)
                        echo "Actif";
                    else
                        echo "Inactif"; ?>
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
