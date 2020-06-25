<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class ContractsController extends AppController
{
    /**
     *  isAuthorized method
     *  filter the actions that are always allowed when user login
     *  @param array $user
     *  @return bool
     */
    public function isAuthorized($user)
    {
        $action = $this->request->params['action'];
        $allowed_method = [
            'index',
            'add',
            'detail',
            'edit',
            'getPatient'
        ];

        if (in_array($action, $allowed_method)) {
            return true;
        }

        $this->Flash->error('You\'re not worthy.');
    }

    /**
     *  index method
     *  index page
     */
    public function index()
    {
        $page = $this->request->query('page');
        $data_limit = 20;

        $conditions = '?limit='.$data_limit;

        if (!is_numeric($page)) {
            $page = 1;
        }

        $conditions .= '&page='.$page;
        $conditions .= '$order=id';

        $response = $this->req('GET', '/contracts'.$conditions);
        $result = $response->json;
        $total_data = 0;
        $contracts = [];
        $paging = [];
        $paging['current'] = 0;

        if (in_array($response->code, [200, 201])) {
            $total_data = $result['data']['total'];
            $contracts = $result['data']['data'];
            $paging = $result['data']['current_page'];
        }

        $this->set(compact('contracts', 'total_data', 'paging', 'data_limit'));
    }

    /**
     *  add method
     *  add contract page and process
     */
    public function add()
    {
        $this->viewBuilder()->layout('modal');

        if ($this->request->is('post')) {
            $pj_id = $this->request->data('pj_id');
            $patient_id = $this->request->data('patient_id');
            $contract_no = rand(0, 999999);

            if (empty($pj_id) || empty($patient_id)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'pj_id' => $pj_id,
                'patient_id' => $patient_id,
                'contract_no' => $contract_no,
                'created_by' => $this->request->session()->read('Auth.User.id'),
                'status' => 1
            ];

            $post_data = $this->req('POST', '/contracts', $data);

            if (in_array($post_data->code, [200, 201])) {
                $this->Flash->success('The data has been saved.');
            } else {
                $this->Flash->error('The data could not be save. Please, try again.');
            }

            return $this->redirect($this->referer());
        }

        $response = $this->req('GET', '/patients');
        $result = $response->json['data'];
        $patients = [];

        if (in_array($response->code, [200, 201])) {
            $patients = $result['data'];
        }

        $response = $this->req('GET', '/pjs');
        $result = $response->json['data'];
        $pjs = [];

        if (in_array($response->code, [200, 201])) {
            $pjs = $result['data'];
        }

        $this->set(compact('patients', 'pjs'));
    }

    /**
     *  detail method
     *  detail page
     */
    public function detail($id)
    {
        $contracts = [];
        $get_contracts = $this->req('GET', '/contracts/'.$id);

        if (in_array($get_contracts->code, [200, 201])) {
            $contracts = (object) $get_contracts->json['data'];
        }

        $this->set(compact('contracts'));
    }

    /**
     *  getPatient method
     *  provide contract patient dropdown data based on given PJ
     */
    public function getPatient()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $pj_id = $this->request->data('pj_id');

            $getPatient = $this->req('GET', '/patients/pjs/'.$pj_id);

            $patient = $getPatient->json;
            echo json_encode($patient);
        }
    }
}