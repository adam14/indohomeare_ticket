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
            'detailPatient',
            'detailPj',
            'edit',
            'getAllNurseContract',
            'getPatient',
            'progressContract'
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
        $conditions .= '&order=id';

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
     *  progressContract method
     *  progress contract process for get contract_id
     */
    public function progressContract()
    {
        $this->autoRender = false;

        $response = $this->req('GET', '/contracts?start='.date('Y-m-01').'&end='.date('Y-m-d'));
        $result = $response->json;
        $total_contract = count($result['data']);

        $no_prefix = $total_contract + 1;
        $contract_no = "NMK.".date("Y-m-").sprintf('%04d', $no_prefix);
        $created_by = $this->request->session()->read('Auth.User.id');
        $status = "Draft";

        $data = [
            'contract_no' => $contract_no,
            'created_by' => $created_by,
            'status' => $status
        ];

        $post_data = $this->req('POST', '/contracts', $data);

        if (in_array($post_data->code, [200, 201])) {
            $this->Flash->success('The data has been saved.');
            return $this->redirect(['controller' => 'Contracts', 'action' => 'add', $post_data->json['data']['contract_no']]);
        } else {
            $this->Flash->error('The data could not be save. Please, try again.');
        }

        return $this->redirect($this->referer());
    }

    /**
     *  add method
     *  add contract page and process
     */
    public function add($contract_no = null)
    {
        //$this->viewBuilder()->layout('modal');

        if (empty($contract_no)) {
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is('post')) {
            $pj_id = $this->request->data('pj_id');
            $patient_id = $this->request->data('patient_id');
            $start_date = $this->request->data('start_date');
            $end_date = $this->request->data('end_date');
            $contract_id = $this->request->data('contract_id');

            if (empty($pj_id) || empty($patient_id) || empty($start_date) || empty($end_date)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'pj_id' => $pj_id,
                'patient_id' => $patient_id,
                'start_date' => $start_date,
                'end_date' => $end_date
            ];

            $post_data = $this->req('PUT', '/contracts/'.$contract_id, $data);

            if (in_array($post_data->code, [200, 201])) {
                $this->Flash->success('Data completed.');
                return $this->redirect(['action' => 'detail', $contract_id]);
            } else {
                $this->Flash->error('The data could not be save. Please, try again.');
            }

            return $this->redirect($this->referer());
        }

        // $contract_no = "NMK.".date("Y-m-").rand(1000,9999);

        $response = $this->req('GET', '/contracts?contract_no='.$contract_no);
        $result = $response->json;
        $contracts = $result['data'];

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

        $this->set(compact('patients', 'pjs', 'contracts'));
    }

    /**
     *  detail method
     *  detail page
     */
    public function detail($id)
    {
        /** Contract Event */
        $response = $this->req('GET', '/event_contracts?contract_id='.$id);
        $result = $response->json['data'];
        $event_contracts = [];

        if (in_array($response->code, [200, 201])) {
            $event_contracts = $result['data'];
        }
        /** End */

        /** Transport Contract */
        $response = $this->req('GET', '/transport_contracts?contract_id='.$id);
        $result = $response->json['data'];
        $transport_contracts = [];

        if (in_array($response->code, [200, 201])) {
            $transport_contracts = $result['data'];
        }
        /** End */

        /** Nurse Contract */
        $response = $this->req('GET', '/nurse_contracts?contract_id='.$id);
        $result = $response->json['data'];
        $nurse_contracts = [];

        if (in_array($response->code, [200, 201])) {
            $nurse_contracts = $result['data'];
        }
        /** End */

        /** Therapist Contract */
        $response = $this->req('GET', '/therapist_contracts?contract_id='.$id);
        $result = $response->json['data'];
        $therapist_contracts = [];

        if (in_array($response->code, [200, 201])) {
            $therapist_contracts = $result['data'];
        }
        /** End */

        /** Medic Tools Contract */
        $response = $this->req('GET', '/medic_tool_contracts?contract_id='.$id);
        $result = $response->json['data'];
        $medic_tool_contracts = [];

        if (in_array($response->code, [200, 201])) {
            $medic_tool_contracts = $result['data'];
        }
        /** End */

        /** Contract Histories */
        $response = $this->req('GET', '/contract_histories');
        $result = $response->json['data'];
        $contract_histories = [];

        if (in_array($response->code, [200, 201])) {
            $contract_histories = $result['data'];
        }
        /** End */

        /** Get PJ */
        $response = $this->req('GET', '/pjs');
        $result = $response->json['data'];
        $pjs = [];

        if (in_array($response->code, [200, 201])) {
            $pjs = $result['data'];
        }
        /** End */

        $contracts = [];
        $get_contracts = $this->req('GET', '/contracts/'.$id);

        if (in_array($get_contracts->code, [200, 201])) {
            $contracts = (object) $get_contracts->json['data'];
        }

        $this->set(compact('contracts', 'event_contracts', 'transport_contracts', 'nurse_contracts', 'therapist_contracts', 'medic_tool_contracts', 'contract_histories', 'pjs'));
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

    /**
     *  detailPatient method
     *  detail patient get result data with patient_id
     */
    public function detailPatient()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $patient_id = $this->request->data('patient_id');

            $detailPatient = $this->req('GET', '/patients/'.$patient_id);

            $patients = $detailPatient->json;
            echo json_encode($patients);
        }
    }

    /**
     *  detailPj method
     *  detail pj get result data with pj_id
     */
    public function detailPj()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $pj_id = $this->request->data('pj_id');

            $detailPj = $this->req('GET', '/pjs/'.$pj_id);

            $pjs = $detailPj->json;
            echo json_encode($pjs);
        }
    }

    /**
     *  getAllNurseContract method
     *  get all nurse contract data with $contract_id
     */
    public function getAllNurseContract()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $contract_id = $this->request->data('contract_id');

            $getAllNurseContract = $this->req('GET', '/nurse_contracts?contract_id='.$contract_id);

            $nurse_contracts = $getAllNurseContract->json;
            echo json_encode($nurse_contracts);
        }
    }
}
