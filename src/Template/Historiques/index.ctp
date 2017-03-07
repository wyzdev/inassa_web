<?= $this->assign('title', 'INASSA - Historique');?>

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
	            <th>Prenom</th>
	            <th>Localisation</th>
	            <th>Carte</th>
	            <th>Date</th>
	            <th>Status</th>
	        </tr>
	    </thead>
	    <tfoot>
	        <tr>
	            <th>Nom</th>
	            <th>Prenom</th>
	            <th>Localisation</th>
	            <th>Carte</th>
	            <th>Date</th>
	            <th>Status</th>
	        </tr>
	    </tfoot>
	    <tbody>
	        <tr>
	            <td>Tiger</td>
	            <td>Jean</td>
	            <td>Edinburgh</td>
	            <td>61</td>
	            <td>2011/04/25</td>
	            <td>Active</td>
	        </tr>
	    </tbody>
	</table>
</div>