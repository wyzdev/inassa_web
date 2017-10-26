<?php
/**
 * Copyright (c) INASSA
 *
 * @copyright     Copyright (c) INASSA 2017
 * @link          http://nassagroup.com
 */
namespace App\Controller;

use App\Controller\AppController;

/**
 * Logs Controller
 *
 * @property \App\Model\Table\LogsTable $Logs
 */
class LogsController extends AppController
{

    /**
     * Function that adds the client's history in database.
     */
    public function add()
    {
        $data = $this->request->data;
        $log = '';
        $message = true;
        if (isset($data['token']) && $this->TOKEN == $data['token']) {
            $log = $this->Logs->newEntity($this->request->getData());
            if ($this->Logs->save($log))
                $message = false;
        }
        $this->set([
            'error' => $message,
            'log' => $log
        ]);
    }

    /**
     * Function that displays the global history.
     */
    public function historique()
    {

        if ($this->request->session()->read('Auth.User')['first_login']) {
            $this->redirect(
                [
                    'controller' => 'clients',
                    'action' => 'gestion'
                ]);
        }
        else if ($this->request->is('post')) {
            $this->getClientHistory();
        }
        else {
            if($this->request->getQueryParams()){
                $this->getClientHistoryViaGet();
            }else {
                $this->getGlobalHistory();
            }
        }
    }

    /**
     * Function that gets client's history via GET request and displays it.
     */
    public function getClientHistoryViaGet(){
        $data = $this->request->getQueryParams();

        $client = $this->Logs->find('all', array(
            'conditions' => array(
                'Logs.first_name' => $data['first_name'],
                'Logs.last_name' => $data['last_name'],
                'Logs.dob' => $data['dob']
            )
        ));
        if ($client)
        {

            $logs = $this->paginate($client);
            $this->set(compact('logs'));
            $this->set('_serialize', ['logs']);


            ////////////////////////// SAVING DATA IN LOGS /////////////////////////////////////////////////////////
            $this->writeinlogs($this->request->session()->read('Auth.User')['first_name']
                .' '.
                $this->request->session()->read('Auth.User')['last_name'],
                $this->request->session()->read('Auth.User')['role'],
                $this->request->session()->read('Auth.User')['institution'],
                "a vérifié l'historique du client",
                strtoupper($data['first_name']).' '.strtoupper($data['last_name'])."\n");
        }

    }

    /**
     * Function that gets the client's history via POST and displays it.
     */
    public function getClientHistory(){
        $data = $this->request->data;
        $client = $this->Logs->find('all', array(
            'conditions' => array(
                'Logs.first_name' => $data['first_name'],
                'Logs.last_name' => $data['last_name'],
                'Logs.dob' => $data['dob']
            )
        ));
        if ($client)
        {

            $logs = $this->paginate($client);
            $this->set(compact('logs'));
            $this->set('_serialize', ['logs']);

            ////////////////////////// SAVING DATA IN LOGS /////////////////////////////////////////////////////////
            $this->writeinlogs($this->request->session()->read('Auth.User')['first_name']
                .' '.
                $this->request->session()->read('Auth.User')['last_name'],
                $this->request->session()->read('Auth.User')['role'],
                $this->request->session()->read('Auth.User')['institution'],
                "a vérifié l'historique du client",
                strtoupper($data['first_name']).' '.strtoupper($data['last_name'])."\n");
        }
        else
        {
        }
    }

    /**
     * Function that gets the global history and displays it.
     */
    public function getGlobalHistory(){
        $logs = $this->Logs->find();
        $this->set(compact('logs'));
        $this->set('_serialize', ['logs']);


        ////////////////////////// SAVING DATA IN LOGS /////////////////////////////////////////////////////////
        $this->writeinlogs($this->request->session()->read('Auth.User')['first_name']
            .' '.
            $this->request->session()->read('Auth.User')['last_name'],
            $this->request->session()->read('Auth.User')['role'],
            $this->request->session()->read('Auth.User')['institution'],
            " est allé dans HISTORIQUE",
            ""."\n");
    }

    /**
     * Function that reads in log files.
     */
    public function readlogs()
    {
        $myfile = fopen("inassa.log", "r") or die("Unable to open file!");
        $content_logs = '';
        while(! feof($myfile))
        {
            $content_logs = $content_logs . fgets($myfile). "<br />";
        }
        fclose($myfile);

        $this->set('log', $content_logs);
    }

    /**
     * Function that clears log files.
     */
    public function clearlogs(){
        if ($this->request->is('ajax')) {
            $my_file = 'inassa.log';
            $handle = fopen($my_file, 'w') or die('Cannot open file:  ' . $my_file);
            file_put_contents($my_file, "");// erase the content of the file
            fclose($handle);

            $this->logsClearBy(
                $this->request->session()->read('Auth.User')['first_name']
                .' '.
                $this->request->session()->read('Auth.User')['last_name']);
            die();
        }
    }

    /**
     * Function that saves the user's name who deleted the logs.
     *
     * @param $user_full_name
     */
    public function logsClearBy($user_full_name){

        date_default_timezone_set('America/New_York');
        $date = date('d/m/Y h:i:s a', time());

        // save in daily log
        $my_file = "Logs/" . date("Y_m_d") . '.log';
        $handle = fopen($my_file, 'a+') or die('Cannot open file:  '.$my_file);

        $data = '[<b>'.$date.'</b>] '. $user_full_name . ' a effacé les logs.';
        fwrite($handle, $data); // write a line in the file
        fclose($handle);
    }
}
