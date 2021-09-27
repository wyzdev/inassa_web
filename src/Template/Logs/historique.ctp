<?= $this->assign('title', 'INASSA - Historique'); ?>

<?= $this->start('nom_du_block'); ?>


<?= $this->end(); ?>



<?= $this->Html->css('historique'); ?>
<?= $this->Html->css('dataTablesbootstrap.min'); ?>
<?= $this->Html->script('date-dropdown/date_dropdowns.min', ['block' => true]) ?>

<?php

$dob_input = (isset($dob)) ? $dob : '';

if (!empty($this->request->getQuery('first_name')) and !empty($this->request->getQuery('last_name')) and !empty($this->request->getQuery('dob'))){
    $first_name = $this->request->getQuery('first_name');
    $last_name =  $this->request->getQuery('last_name');
    $birthdate =  $this->request->getQuery('dob');
} else {
    $first_name = "";
    $last_name =  "";
    $birthdate =  "";
}
?>

<style type="text/css">
    .borderRight{
        border-right: solid #ddd 2px;
        font-weight: bold;
    }
</style>
    <div class="container" style="margin-top: 15px">
        <div class="row">
            <div id="" class="">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?= $this->Form->create("Logs", array('class' => "form-inline")) ?>
                        <div class="form-group col-md-2 col-md-offset-0 col-xs-10 col-xs-offset-1">
                            <?= $this->Form->input("last_name", array("class" => "form-control margin-10",
                                "label" => false, "placeholder" => "NOM", 'value' => $last_name)) ?>
                        </div>
                        <div class="form-group col-md-2 col-md-offset-1 col-xs-10 col-xs-offset-1">
                            <?= $this->Form->input("first_name", array("class" => "form-control margin-10",
                                "label" => false, "placeholder" => "Prénom", 'value' => $first_name)) ?>
                        </div>
                        <div class="form-group col-md-4 col-md-offset-1 col-xs-10 col-xs-offset-1"
                             style="margin-top: 5px;">

                            <input name="dob" id="datepicker_dropdown" type="text" class="form-control "
                                   placeholder="Date de naissance" value="<?= $birthdate ?>">
                        </div> <!-- form group [order by] -->
                        <div class="form-group  col-md-2 col-md-offset-0 col-xs-10 col-xs-offset-1">
                            <button type="submit" class="btn btn-default filter-col" style="margin-top: 4px;">
                                <span class="glyphicon glyphicon-search"></span> Rechercher
                            </button>
                        </div>
                        <!-- </form>-->
                        <?= $this->Form->end() ?>
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
                <th class='text-center'>Code de confirmation</th>
                <th class="text-center">Identification</th>
                <th class='text-center'>Nom</th>
                <th class='text-center'>Prénom</th>
                <th class='text-center'>DOB (JJ/M/AAAA)</th>
                <th class='text-center'>Numéro de police hérité</th>
                <th class='text-center'>Institution</th>
                <th class='text-center'>Source</th>
                <th class='text-center'>Date (JJ/MM/AAAA HH:MN)</th>
                <th class='text-center'>Dépendant</th>
                <th class='text-center'>Assuré Principal</th>
                <th class='text-center'>Hero</th>
                <th>Status</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th class='text-center'>Code de confirmation</th>
                <th class="text-center">Identification</th>
                <th class='text-center'>Nom</th>
                <th class='text-center'>Prénom</th>
                <th class='text-center'>DOB (JJ/MM/AAAA)</th>
                <th class='text-center'>Numéro de police hérité</th>
                <th class='text-center'>Institution</th>
                <th class='text-center'>Source</th>
                <th class='text-center'>Date (JJ/MM/AAAA, HH:MN)</th>
                <th class='text-center'>Dépendant</th>
                <th class='text-center'>Assuré Principal</th>
                <th class='text-center'>Hero</th>
                <th>Status</th>
            </tr>
            </tfoot>
            <tbody>
            <?php foreach ($logs as $log): ?>
                <?php if ($log->status) : ?>
                    <tr>
                <?php else : ?>
                    <tr class=' backgroundRed'>
                <?php endif; ?>
                <td class="text-center borderRight"><b><?= $log->confirmation_code ?></b></td>
                <td class="text-center"><?= $log->employee_id ?></td>
                <td class='text-center'><?= $log->last_name ?></td>
                <td class='text-center'><?= $log->first_name ?></td>
                <!--<td class = 'text-center'><? /*=  //date("d/m/Y", strtotime($log->dob)) */ ?></td>-->
                <?php

                $date = explode('/', $log->dob);
                $day = $date[0];
                $month = $date[1];
                $year = $date[2];

                //debug(date("d/M/YYYY", strtotime($log->dob)));
                //debug($log->dob->i18nFormat('dd/MM/yyyy'));
                //die;

                //$log->dob = $day . '/' . $month . '/' . $year;
                //$log->dob = str_replace('/', '-', $log->dob);
                //$timestamp = strtotime($log->dob);
                setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
                ?>
                <td class='text-center'><?= $log->dob->i18nFormat('dd/MM/yyyy') ?></td>
                <td class='text-center'><?= $log->legacy_policy ?></td>
                <td class='text-center'><?= $log->institution ?></td>
                <td class='text-center'><?= $log->doctor_name ?></td><!--
                //////////////////                    <td></td>
//////////////////////////////// -->
                <?php

                $timestamp = strtotime($log->date);
                setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
                ?><!--
                ///////////////////////////////////////////////// -->
                <td class='text-center'><?= strftime("%d/%m/%Y %H:%M", $timestamp); ?></td>
                <?php if ($log->is_dependant): ?>
                    <td class='text-center'>OUI</td>
                    <td class='text-center'><?= $log->primary_name ?></td>
                <?php else : ?>
                    <td class='text-center'>NON</td>
                    <td class='text-center'>-</td>
                <?php endif; ?>
                <?php if ($log->hero == 'N/A') : ?>
                    <td class="text-center">N/A</td>
                <?php else : ?>
                    <td class="text-center"><span class="label label-danger"><?= $log->hero ?></span></td>
                <?php endif; ?>
                <td>
                    <?php
                    if ($log->status)
                        echo "<span class = 'label label-success'>Actif</span>";
                    else
                        echo "Inactif"; ?>
                </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!--/////////////////////////////// LOADER /////////////////////////////////////////-->
    <div id="content_loader"
         style="background: #fff; height: 100vh;  top:0px; left: 0px; right: 0px; position: absolute; z-index: 2;">
        <div id="loader"></div>
    </div>


<?= $this->Html->scriptStart(['block' => true]) ?>
<?= "$(function(){
        $('.day, .month, .year').attr('class', 'form-control');
    })"; ?>
<?= $this->Html->scriptEnd(); ?>

<?= $this->Html->scriptStart(['block' => true]) ?>
<?= "$(function(){
        $('.day, .month, .year').attr('class', 'form-control');
    })"; ?>
<?= $this->Html->scriptEnd(); ?>