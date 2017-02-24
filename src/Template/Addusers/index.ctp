<?= $this->assign('title', 'INASSA - Ajouter un utilisateur'); ?>

<?= $this->Html->css('add_user'); ?>
<?= $this->Html->css('login_form'); ?>




<div class="container-fluid">
	<div class="row">
		<div class=" col-lg-4 col-lg-offset-0 col-md-4 col-md-offset-0 col-sm-8 col-sm-offset-2 vertical-center">
	        <div class="col-xs-10 col-xs-offset-1 col-md-12 col-md-offset-0">
	            <div class="account-wall">
	            	<h3 class="center">Ajouter un nouvel utilisateur</h3>
	                <form class="form-signin" method = "post" action = "/inassa_web/accueil.php">
		                <input type="text" class="form-control margin-10" placeholder="Nom">
		                <input type="text" class="form-control margin-10" placeholder="Prenom">
		                <input type="text" class="form-control margin-10" placeholder="Nom d'utilisateur">
		                <div class="check-container"">
		                	<input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Admin</label>
		                </div>
		                
		                <a href="accueil.php">
		                	<button class="btn btn-lg btn-primary btn-block" type="submit">
		                    Enregistrer</button>
		                </a>
	                </form>
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
			            <td>Tiger</td>
			            <td>Jean</td>
			            <td>Edinburgh</td>
			            <td><input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Admin</label></td>
			            <td>
			            	<input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Actif</label>
			            </td>
			            <td>
			            	<a href=""><span class="glyphicon glyphicon-retweet dark" style="color: red; margin-left: 30px;"></span></a>
			            </td>
			        </tr>
			        <tr>
			            <td>Tiger</td>
			            <td>Jean</td>
			            <td>Edinburgh</td>
			            <td><input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Admin</label></td>
			            <td>
			            	<input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Actif</label>
			            </td>
			            <td>
			            	<a href=""><span class="glyphicon glyphicon-retweet dark" style="color: red; margin-left: 30px;"></span></a>
			            </td>
			        </tr>
			        <tr>
			            <td>Tiger</td>
			            <td>Jean</td>
			            <td>Edinburgh</td>
			            <td><input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Admin</label></td>
			            <td>
			            	<input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Actif</label>
			            </td>
			            <td>
			            	<a href=""><span class="glyphicon glyphicon-retweet dark" style="color: red; margin-left: 30px;"></span></a>
			            </td>
			        </tr>
			        <tr>
			            <td>Tiger</td>
			            <td>Jean</td>
			            <td>Edinburgh</td>
			            <td><input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Admin</label></td>
			            <td>
			            	<input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Actif</label>
			            </td>
			            <td>
			            	<a href=""><span class="glyphicon glyphicon-retweet dark" style="color: red; margin-left: 30px;"></span></a>
			            </td>
			        </tr>
			        <tr>
			            <td>Tiger</td>
			            <td>Jean</td>
			            <td>Edinburgh</td>
			            <td><input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Admin</label></td>
			            <td>
			            	<input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Actif</label>
			            </td>
			            <td>
			            	<a href=""><span class="glyphicon glyphicon-retweet dark" style="color: red; margin-left: 30px;"></span></a>
			            </td>
			        </tr>
			        <tr>
			            <td>Tiger</td>
			            <td>Jean</td>
			            <td>Edinburgh</td>
			            <td><input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Admin</label></td>
			            <td>
			            	<input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Actif</label>
			            </td>
			            <td>
			            	<a href=""><span class="glyphicon glyphicon-retweet dark" style="color: red; margin-left: 30px;"></span></a>
			            </td>
			        </tr>
			        <tr>
			            <td>Tiger</td>
			            <td>Jean</td>
			            <td>Edinburgh</td>
			            <td><input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Admin</label></td>
			            <td>
			            	<input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Actif</label>
			            </td>
			            <td>
			            	<a href=""><span class="glyphicon glyphicon-retweet dark" style="color: red; margin-left: 30px;"></span></a>
			            </td>
			        </tr>
			        <tr>
			            <td>Tiger</td>
			            <td>Jean</td>
			            <td>Edinburgh</td>
			            <td><input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Admin</label></td>
			            <td>
			            	<input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Actif</label>
			            </td>
			            <td>
			            	<a href=""><span class="glyphicon glyphicon-retweet dark" style="color: red; margin-left: 30px;"></span></a>
			            </td>
			        </tr>
			        <tr>
			            <td>Tiger</td>
			            <td>Jean</td>
			            <td>Edinburgh</td>
			            <td><input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Admin</label></td>
			            <td>
			            	<input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Actif</label>
			            </td>
			            <td>
			            	<a href=""><span class="glyphicon glyphicon-retweet dark" style="color: red; margin-left: 30px;"></span></a>
			            </td>
			        </tr>
			        <tr>
			            <td>Tiger</td>
			            <td>Jean</td>
			            <td>Edinburgh</td>
			            <td><input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Admin</label></td>
			            <td>
			            	<input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Actif</label>
			            </td>
			            <td>
			            	<a href=""><span class="glyphicon glyphicon-retweet dark" style="color: red; margin-left: 30px;"></span></a>
			            </td>
			        </tr>
			        <tr>
			            <td>Tiger</td>
			            <td>Jean</td>
			            <td>Edinburgh</td>
			            <td><input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Admin</label></td>
			            <td>
			            	<input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Actif</label>
			            </td>
			            <td>
			            	<a href=""><span class="glyphicon glyphicon-retweet dark" style="color: red; margin-left: 30px;"></span></a>
			            </td>
			        </tr>
			        <tr>
			            <td>Tiger</td>
			            <td>Jean</td>
			            <td>Edinburgh</td>
			            <td><input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Admin</label></td>
			            <td>
			            	<input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Actif</label>
			            </td>
			            <td>
			            	<a href=""><span class="glyphicon glyphicon-retweet dark" style="color: red; margin-left: 30px;"></span></a>
			            </td>
			        </tr>
			        <tr>
			            <td>Tiger</td>
			            <td>Jean</td>
			            <td>Edinburgh</td>
			            <td><input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Admin</label></td>
			            <td>
			            	<input type="checkbox" name="admin" value="value-admin">&nbsp;&nbsp;<label class="">Actif</label>
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