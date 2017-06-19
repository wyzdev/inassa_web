<?php
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
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
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



    public function historique()
    {
        echo $this->Logs;

        if ($this->request->session()->read('Auth.User')['first_login']) {
            $this->redirect(
                [
                    'controller' => 'clients',
                    'action' => 'gestion'
                ]);
        }
        else if ($this->request->is('post')) {
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
        else {
            if($this->request->getQueryParams()){
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

            }else {
                $logs = $this->paginate($this->Logs);
                $this->set(compact('logs'));
                $this->set('_serialize', ['logs']);


                ////////////////////////// SAVING DATA IN LOGS /////////////////////////////////////////////////////////
                $this->writeinlogs($this->request->session()->read('Auth.User')['first_name']
                    .' '.
                    $this->request->session()->read('Auth.User')['last_name'],
                    $this->request->session()->read('Auth.User')['role'],
                    $this->request->session()->read('Auth.User')['institution'],
                    " est allé dana HISTORIQUE",
                    ""."\n");
            }
        }
    }

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

    public function clearlogs(){
        if ($this->request->is('ajax')) {
            $my_file = 'inassa.log';
            $handle = fopen($my_file, 'w') or die('Cannot open file:  ' . $my_file);
            file_put_contents($my_file, "");// erase the content of the file
            fclose($handle);
            die();
        }
    }
}
