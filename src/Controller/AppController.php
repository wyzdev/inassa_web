<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Controller\Component\RequestHandlerComponent;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public $TOKEN = "1E:DF:D8:32:09:92:72:AF:FA:32:12:71:D6:B5:E4:70:DB:F2:7F:48";

    /**
     * @return string
     */
    public function getTOKEN()
    {
        return $this->TOKEN;
    }
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
                'controller' => 'clients',
                'action' => 'gestion'
            ],
            'logoutRedirect' => [
                'controller' => 'users',
                'action' => 'login'
            ]
        ]);

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
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
     * @param Event $event
     *
     */
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['add', 'requestUser', 'forgotPassword', 'changePasswordMedecin', 'search']);
    }

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
}
