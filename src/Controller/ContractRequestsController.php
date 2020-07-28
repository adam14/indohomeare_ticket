<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class ContractRequestsController extends AppController
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
            'add'
        ];

        if (in_array($action, $allowed_method)) {
            return true;
        }

        $this->Flash->error('You\'re not worthy.');
    }

    /**
     *  index method
     *  index process
     */
    public function index()
    {
        $pjs = $this->req('GET', '/pjs')->json['data']['data'];

        $page = $this->request->query('page');
        $disable_date = $this->request->query('disable_date');
        $start_date = $this->request->query('start_date');
        $end_date = $this->request->query('end_date');
        $no_contract = $this->request->query('no_contract');
        $pj_id = $this->request->query('pj_id');
        $name_patient = $this->request->query('name_patient');
        $status_contract = $this->request->query('status_contract');
        $action_contract = $this->request->query('action_contract');

        $current_date = date('Y-m-d');

        $start_check = strtotime($start_date);
        $end_check = strtotime($end_date);
        $current_check = strtotime($current_date);
		
		$start_date = ($start_check == false || $start_check > $current_check) ? $current_check : $start_check;
		$end_date = ($end_check == false || $end_check > $current_check) ? $current_check : $end_check;

        $data_limit = 20;

        $conditions = '?limit='.$data_limit;

        if (!empty($action_contract)) {
            $conditions .= '&action_contract='.$action_contract;
        }

        if ($disable_date != 1) {
            $conditions .= '&start='.$start_date.'&end='.$end_date;
        }

        if (!empty($no_contract)) {
            $conditions .= '&contract_no='.$no_contract;
        }

        if (!empty($pj_id)) {
            $conditions .= '&pj_id='.$pj_id;
        }

        if (!empty($name_patient)) {
            $conditions .= '&name_patient='.$name_patient;
        }

        if (!empty($status_contract)) {
            $conditions .= '&status='.$status_contract;
        }

        if (!empty($patient_id)) {
            $conditions .= '&patient_id='.$patient_id;
        }

        if (!is_numeric($page)) {
            $page = 1;
        }

        $conditions .= '&page='.$page;
        $conditions .= '&order=id';

        $response = $this->req('GET', '/contract_requests'.$conditions);
        $result = $response->json;

        $total_data = 0;
        $contracts = [];
        $paging = [];
        $paging['current'] = 0;

        if (in_array($response->code, [200, 201])) {
            $total_data = (!empty($result['data']['total'])) ? $result['data']['total'] : 0;
            $contracts = (!empty($result['data']['data'])) ? $result['data']['data'] : [];
            $paging = (!empty($result['data']['current_page'])) ? $result['data']['current_page'] : 0;
        }

        $this->set(compact('contracts', 'total_data', 'paging', 'data_limit', 'pjs'));
    }

    public function add($contract_no = null)
    {
        $this->viewBuilder()->layout('modal');

        if ($this->request->is('post')) {
            $name = htmlentities($this->request->data('name'));
            $medic_tool_category = $this->request->data('medic_tool_category');

            if (empty($name) || empty($medic_tool_category)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'name' => $name,
                'medic_tool_category' => $medic_tool_category
            ];

            $post_data = $this->req('POST', '/medic_tools', $data);

            if (in_array($post_data->code, [200, 201])) {
                $this->Flash->success('The data has been saved.');
            } else {
                $this->Flash->error('The data could not be save. Please, try again.');
            }

            return $this->redirect($this->referer());
        }
    }
}