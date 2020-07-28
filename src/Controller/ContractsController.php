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
            'getAllEventContract',
            'getAllMedicToolContract',
            'getAllNurseContract',
            'getAllTherapistContract',
            'getAllTransportContract',
            'getHistory',
            'getPatient',
            'print',
            'printNew',
            'progressContract',
            'report',
            'updateContract',
            'updateStatus'
        ];

        if (in_array($action, $allowed_method)) {
            return true;
        }

        $this->Flash->error('You\'re not worthy.');
    }

    public function print($id = null)
    {
        $this->viewBuilder()->layout('invoice');
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

    public function printNew($id = null)
    {
        $this->viewBuilder()->layout('invoice');
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
     *  index method
     *  index page
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
        $patient_id = $this->request->query('patient_id');

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

        $response = $this->req('GET', '/contracts'.$conditions);
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

    /**
     *  progressContract method
     *  progress contract process for get contract_id
     */
    public function progressContract()
    {
        $this->autoRender = false;

        $response = $this->req('GET', '/contracts?start_no='.date('Y-m-01').'&end_no='.date('Y-m-d'));
        $result = $response->json;
        // $total_contract = count($result['data']);
        $total_contract = $result['data']['total'];

        $no_prefix = $total_contract + 1;
        $contract_no = "NMK.".date("Y-m-").sprintf('%04d', $no_prefix);
        $created_by = $this->request->session()->read('Auth.User.id');
        $status = "Draft";

        $data = [
            'contract_no' => $contract_no,
            'created_by' => $created_by,
            'status' => $status,
            'contract_status_id' => 1
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
        if (empty($contract_no)) {
            return $this->redirect(['action' => 'index']);
        }


        if ($this->request->is('post')) {
            $pj_id = $this->request->data('pj_id');
            $patient_id = $this->request->data('patient_id');
            $start_date = $this->request->data('start_date');
            $end_date = $this->request->data('end_date');
            $contract_id = $this->request->data('contract_id');
            $total_price = $this->request->data('total_price');

            if (empty($pj_id) || empty($patient_id) || empty($start_date) || empty($end_date)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'pj_id' => $pj_id,
                'patient_id' => $patient_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'total_price' => (!empty($total_price)) ? $total_price : 0,
                'status' => 'Deal',
                'contract_status_id' => 2
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

        $response = $this->req('GET', '/contracts?contract_no='.$contract_no);
        $result = $response->json;
        $contracts = $result['data']['data'][0];

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
     *  report method
     *  report page
     */
    public function report()
    {
    }

    /**
     *  updateContract method
     *  update contract with contract_id
     */
    public function updateContract()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $id = $this->request->data('contract_id');
            $pj_id = $this->request->data('contract_pj_id');
            $patient_id = $this->request->data('contract_patient_id');
            $start_date = $this->request->data('start_date');
            $end_date = $this->request->data('end_date');

            $data = [
                'pj_id' => $pj_id,
                'patient_id' => $patient_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $put_data = $this->req('PUT', '/contracts/'.$id, $data);
            $updateData = $put_data->json;

            if ($updateData['status'] == 'true') {
                $this->Flash->success('Data successfully edited.');
            } else {
                $this->Flash->error('The contract could not be edited. Please, try again.');
            }

            return $this->redirect($this->referer());
        }
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

    /**
     *  getAllTherapistContract method
     *  get all therapist contract data with $contract_id
     */
    public function getAllTherapistContract()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $contract_id = $this->request->data('contract_id');

            $getAllTherapistContract = $this->req('GET', '/therapist_contracts?contract_id='.$contract_id);

            $therapist_contracts = $getAllTherapistContract->json;
            echo json_encode($therapist_contracts);
        }
    }

    /**
     *  getAllMedicToolContract method
     *  get all medic tool contract data with $contract_id
     */
    public function getAllMedicToolContract()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $contract_id = $this->request->data('contract_id');

            $getAllMedicToolContract = $this->req('GET', '/medic_tool_contracts?contract_id='.$contract_id);

            $medic_tool_contracts = $getAllMedicToolContract->json;
            echo json_encode($medic_tool_contracts);
        }
    }

    /**
     *  getAllTransportContract method
     *  get all transport contract data with $contract_id
     */
    public function getAllTransportContract()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $contract_id = $this->request->data('contract_id');

            $getAllTransportContract = $this->req('GET', '/transport_contracts?contract_id='.$contract_id);

            $transport_contracts = $getAllTransportContract->json;
            echo json_encode($transport_contracts);
        }
    }

    /**
     *  getAllEventContract method
     *  get all event contract data with $contract_id
     */
    public function getAllEventContract()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $contract_id = $this->request->data('contract_id');

            $getAllEventContract = $this->req('GET', '/event_contracts?contract_id='.$contract_id);

            $event_contracts = $getAllEventContract->json;
            echo json_encode($event_contracts);
        }
    }

    /**
     *  getHistory method
     *  get history all data contract history with $contract_id
     */
    public function getHistory()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $contract_id = $this->request->data('contract_id');

            $getHistory = $this->req('GET', '/contract_histories?contract_id='.$contract_id);
            
            $contract_histories = $getHistory->json;
            echo json_encode($contract_histories);
        }
    }

    /**
     *  updateStatus method
     *  update status contract with $contract_id
     */
    public function updateStatus()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $id = $this->request->data('id');
            $status = $this->request->data('status');
            $contract_status_id = '';

            if ($status == 'Done') {
                $contract_status_id = 3;
            }
        
            if ($status == 'No Response') {
                $contract_status_id = 4;
            }

            if ($status == 'Cancelled') {
                $contract_status_id = 5;
            }

            $data = [
                'status' => $status,
                'contract_status_id' => $contract_status_id,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $put_data = $this->req('PUT', '/contracts/'.$id, $data);

            $updateStatus = $put_data->json;
            echo json_encode($updateStatus);
        }
    }
}
