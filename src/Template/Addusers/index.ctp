<?= $this->assign('title', 'INASSA - Ajouter un utilisateur'); ?>

<?= $this->Html->css('add_user'); ?>
<?= $this->Html->css('login_form'); ?>




<div class="container-fluid">
	<div class="row">
		<div class=" col-lg-4 col-lg-offset-0 col-md-4 col-md-offset-0 col-sm-8 col-sm-offset-2 vertical-center">
	        <div class="col-xs-10 col-xs-offset-1 col-md-12 col-md-offset-0">
	            <div class="account-wall">
	            	<h3 class="center">Ajouter un nouvel utilisateur</h3>
	                <div class="form-signin">
		                <?= $this->Form->create($user); ?>
	                        <?= $this->Form->input('first_name', array('class' => 'form-control margin-10', 'label'=>false, "placeholder"=>"Prenom")) ?>
	                        <?= $this->Form->input('last_name', array('class' => 'form-control margin-10', 'label'=>false,"placeholder"=>"NOM")) ?>
	                        <?= $this->Form->input('username', array('class' => 'form-control margin-10', 'label'=>false, "placeholder"=>"Nom d'utilisateur")) ?>
	                        <?= $this->Form->input('email', array('type' => 'email', 'class' => 'form-control margin-10', 'label'=>false, "placeholder"=>"E-mail")) ?>
	                        <div class="check-container">
	                        	<?= $this->Form->input('access', array('type' => 'checkbox', 'class' => 'bold', 'value' => 'value-admin', 'label' => 'Admin'))?>
	                        	
	                        </div>

	                        <?= $this->Form->button('Enregistrer', ['class' => 'margin-top-20 btn btn-lg btn-primary btn-block']) ?>
	                    <?= $this->Form->end(); ?>
                    </div>
	            </div>
		    </div>
		</div>
		<div class="col-lg-8 col-md-8 col-sm-12 table-responsive">
			<table id="example" class="table table-striped table-hover table-condensed" cellspacing="0" width="100%">
		    <thead>
			        <tr>
			            <th>Nom</th>
			            <th>Prenom</th>
			            <th>Nom d'utilisateur</th>
			            <th>Acces</th>
			            <th>Status</th>
			            <th>Reinitialiser</th>
			        </tr>
			    </thead>
			    <tfoot>
			        <tr>
			            <th>Nom</th>
			            <th>Prenom</th>
			            <th>Nom d'utilisateur</th>
			            <th>Acces</th>
			            <th>Status</th>
			            <th>Reinitialiser</th>
			        </tr>
			    </tfoot>
			    <tbody>
			        <tr>
			            <td>Kent</td>
			            <td>Clark</td>
			            <td>clark_kent</td>
			            <td>
			            	<label class="" for="admin">
			            		<input type="checkbox" name="admin" id="admin" value="value-admin">&nbsp;&nbsp;Admin
			            	</label>
			            </td>
			            <td>
			            	<label class="" for="actif">
			            		<input type="checkbox" id="actif" name="admin" value="value-admin">&nbsp;&nbsp;Actif
			            	</label>
			            </td>
			            <td>
			            	<a href=""><span class="glyphicon glyphicon-retweet dark" style="color: red; margin-left: 30px;"></span></a>
			            </td>
			        </tr>
			       
			      
			    </tbody>
			</table>
		</div>
    </div>
</div>