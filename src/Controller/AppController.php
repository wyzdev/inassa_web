<?php

/**
 * Copyright (c) INASSA
 *
 * @copyright     Copyright (c) INASSA 2017
 * @link          http://nassagroup.com
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Controller\Component\RequestHandlerComponent;

/**
 * Application Controller
 */
class AppController extends Controller
{
    protected $secureActions = array(
        'login',
        '',
        ''
    );
    /**
     * Constants that used to check the requests of the android application
     * @var string
     */
    public $TOKEN = "1E:DF:D8:32:09:92:72:AF:FA:32:12:71:D6:B5:E4:70:DB:F2:7F:48";

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'loginRedirect' => [
                'controller' => 'users',
                'action' => 'login'
            ],
            'logoutRedirect' => [
                'controller' => 'users',
                'action' => 'login'
            ],
            'authError' => 'Votre session a expiré. Vous devez vous authentifier à nouveau.'
        ]);
    }
    public function forceSSL()
    {
        return $this->redirect('https://' . env('SERVER_NAME') . $this->request->here);
    }
    /**
     * Function that allows to make some action before the render of the web application.
     * @param Event $event
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    /**
     * Function that allows some action to execute without the user's authentication.
     * @param Event $event
     *
     */
    public function beforeFilter(Event $event)
    {
        if (in_array($this->request->action, $this->secureActions)
            && !isset($_SERVER['HTTPS'])) {
            $this->forceSSL();
        }

        $this->Auth->allow(['add', 'requestUser', 'forgotPassword', 'changePasswordMedecin', 'search', 'forgotpass', 'login', 'logout']);
        $this->Auth->authError = __('Vous devez vous connecter pour pouvoir accéder à cette fonctionnalité.');
        // $this->Auth->loginError = __('Invalid Username or Password entered, please try again.');
    }

    /**
     * Function that writes in log files.
     *
     * @param $user
     * @param $role
     * @param $from
     * @param $action
     * @param $client
     */
    public function writeinlogs($user, $role, $from, $action, $client){
        date_default_timezone_set('America/New_York');
        $date = date('d/m/Y h:i:s a', time());

        // save in current log
        $file = 'inassa.log';
        $oldContents = file_get_contents($file);

        $handle = fopen($file, 'w') or die('Cannot open file:  '.$file);
        $data = '[<b>'.$date.'</b>] '. $user. ' '.'('.$role.')'.' de '.$from.' '.$action.' '.$client;

        $newmsg = $data . $oldContents;
        fwrite($handle, $newmsg); // write a line in the file
        fclose($handle);

        // save in daily log
        $my_file = "Logs/" . date("Y_m_d") . '.log';
        $handle = fopen($my_file, 'a+') or die('Cannot open file:  '.$my_file);

        $data = '[<b>'.$date.'</b>] '. $user. ' '.'('.$role.')'.' de '.$from.' '.$action.' '.$client;
        fwrite($handle, $data); // write a line in the file
        fclose($handle);
    }

    public function manuel(){
        
    }
}
