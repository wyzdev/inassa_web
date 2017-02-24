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
	        <tr>
	            <td>Garrett Winters</td>
	            <td>Philippe</td>
	            <td>Tokyo</td>
	            <td>63</td>
	            <td>2011/07/25</td>
	            <td>Active</td>
	        </tr>
	        <tr>
	            <td>Ashton Cox</td>
	            <td>Michel</td>
	            <td>San Francisco</td>
	            <td>66</td>
	            <td>2009/01/12</td>
	            <td>Active</td>
	        </tr>
	        <tr>
	            <td>Cedric Kelly</td>
	            <td>Alain</td>
	            <td>Edinburgh</td>
	            <td>22</td>
	            <td>2012/03/29</td>
	            <td>Active</td>
	        </tr>
	        <tr>
	            <td>Airi Satou</td>
	            <td>Patrick</td>
	            <td>Tokyo</td>
	            <td>33</td>
	            <td>2008/11/28</td>
	            <td>Active</td>
	        </tr>
	        <tr>
	            <td>Brielle Williamson</td>
	            <td>Nicolas</td>
	            <td>New York</td>
	            <td>61</td>
	            <td>2012/12/02</td>
	            <td>Inactive</td>
	        </tr>
	        <tr>
	            <td>Herrod Chandler</td>
	            <td>Christophe</td>
	            <td>San Francisco</td>
	            <td>59</td>
	            <td>2012/08/06</td>
	            <td>Inactive</td>
	        </tr>
	        <tr>
	            <td>Rhona Davidson</td>
	            <td>Pierre</td>
	            <td>Tokyo</td>
	            <td>55</td>
	            <td>2010/10/14</td>
	            <td>Active</td>
	        </tr>
	        <tr>
	            <td>Colleen Hurst</td>
	            <td>Christian</td>
	            <td>San Francisco</td>
	            <td>39</td>
	            <td>2009/09/15</td>
	            <td>Active</td>
	        </tr>
	        <tr>
	            <td>Sonya Frost</td>
	            <td>Éric</td>
	            <td>Edinburgh</td>
	            <td>23</td>
	            <td>2008/12/13</td>
	            <td>Active</td>
	        </tr>
	        <tr>
	            <td>Jena Gaines</td>
	            <td>Frédéric</td>
	            <td>London</td>
	            <td>30</td>
	            <td>2008/12/19</td>
	            <td>Active</td>
	        </tr>
	        <tr>
	            <td>Quinn Flynn</td>
	            <td>Laurent</td>
	            <td>Edinburgh</td>
	            <td>22</td>
	            <td>2013/03/03</td>
	            <td>Active</td>
	        </tr>
	        <tr>
	            <td>Charde Marshall</td>
	            <td>Stéphane</td>
	            <td>San Francisco</td>
	            <td>36</td>
	            <td>2008/10/16</td>
	            <td>Active</td>
	        </tr>
	        <tr>
	            <td>Haley Kennedy</td>
	            <td>David</td>
	            <td>London</td>
	            <td>43</td>
	            <td>2012/12/18</td>
	            <td>Active</td>
	        </tr>
	        <tr>
	            <td>Tatyana Fitzpatrick</td>
	            <td>Pascal</td>
	            <td>London</td>
	            <td>19</td>
	            <td>2010/03/17</td>
	            <td>Active</td>
	        </tr>
	        <tr>
	            <td>Michael Silva</td>
	            <td>Daniel</td>
	            <td>London</td>
	            <td>66</td>
	            <td>2012/11/27</td>
	            <td>Active</td>
	        </tr>
	        <tr>
	            <td>Paul Byrd</td>
	            <td>Julien</td>
	            <td>New York</td>
	            <td>64</td>
	            <td>2010/06/09</td>
	            <td>Inactive</td>
	        </tr>
	        <tr>
	            <td>Gloria Little</td>
	            <td>Alexandre</td>
	            <td>New York</td>
	            <td>59</td>
	            <td>2009/04/10</td>
	            <td>Active</td>
	        </tr>
	        <tr>
	            <td>Bradley Greer</td>
	            <td>Thierry</td>
	            <td>London</td>
	            <td>41</td>
	            <td>2012/10/13</td>
	            <td>Active</td>
	        </tr>
	        <tr>
	            <td>Dai Rios</td>
	            <td>Olivier</td>
	            <td>Edinburgh</td>
	            <td>35</td>
	            <td>2012/09/26</td>
	            <td>Inactive</td>
	        </tr>
	        <tr>
	            <td>Jenette Caldwell</td>
	            <td>Bernard</td>
	            <td>New York</td>
	            <td>30</td>
	            <td>2011/09/03</td>
	            <td>Active</td>
	        </tr>
	        <tr>
	            <td>Yuri Berry</td>
	            <td>Thomas</td>
	            <td>New York</td>
	            <td>40</td>
	            <td>2009/06/25</td>
	            <td>Active</td>
	        </tr>
	        <tr>
	            <td>Caesar Vance</td>
	            <td>Sébastien</td>
	            <td>New York</td>
	            <td>21</td>
	            <td>2011/12/12</td>
	            <td>Active</td>
	        </tr>
	    </tbody>
	</table>
</div>