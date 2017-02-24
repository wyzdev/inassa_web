<?php 
/**
* 
*/
namespace App\Controller;
use App\Controller\AppController;
class AuthentificationsController extends AppController{

	public function index(){
		$this->viewBuilder()->setLayout('authentification_layout');
	}
}
