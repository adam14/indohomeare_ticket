<?php
namespace App\Controller;

use App\Controller\AppController;

class TherapistContractsController extends AppController
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
            'edit',
            'delete',
            'getTherapist',
            'getTherapistSessions',
            'saveTherapistContract'
        ];

        if (in_array($action, $allowed_method)) {
            return true;
        }

        $this->Flash->error('You\'re not worthy.');
    }

    /**
     *  add method
     *  add therapist contracts page and process
     */
    public function add($id)
    {
        if (!is_numeric($id)) {
            $this->autoRender = false;
			echo 'There was an error.';
        }

        $this->viewBuilder()->layout('modal');

        if ($this->request->is('post')) {
            $contract_id = $this->request->data('contract_id');
            $therapist_id = $this->request->data('therapist_id');
            $therapist_session_id = $this->request->data('therapist_session_id');

            if (empty($contract_id) || empty($therapist_id) || empty($therapist_session_id)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'contract_id' => $contract_id,
                'therapist_id' => $therapist_id,
                'therapist_session_id' => $therapist_session_id
            ];

            $post_data = $this->req('POST', '/therapist_contracts', $data);

            if (in_array($post_data->code, [200, 201])) {
                $this->Flash->success('The data has been saved.');
            } else {
                $this->Flash->error('The data could not be save. Please, try again.');
            }

            return $this->redirect($this->referer());
        }

        $response = $this->req('GET', '/therapist');
        $result = $response->json['data'];
        $therapist = [];

        if (in_array($response->code, [200, 201])) {
            $therapist = $result['data'];
        }

        $response = $this->req('GET', '/therapist_session');
        $result = $response->json['data'];
        $therapist_session = [];

        if (in_array($response->code, [200, 201])) {
            $therapist_session = $result['data'];
        }

        $this->set(compact('id', 'therapist', 'therapist_session'));
    }

    /**
     *  edit method
     *  edit therapist contract page and process
     */
    public function edit($id = null)
    {
        if (!is_numeric($id)) {
            $this->autoRender = false;
            echo 'There was an error';
        }

        $this->viewBuilder()->layout('modal');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $contract_id = $this->request->data('contract_id');
            $therapist_id = $this->request->data('therapist_id');
            $therapist_session_id = $this->request->data('therapist_session_id');

            if (empty($contract_id) || empty($therapist_id) || empty($therapist_session_id)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'contract_id' => $contract_id,
                'therapist_id' => $therapist_id,
                'therapist_session_id' => $therapist_session_id,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $put_data = $this->req('PUT', '/therapist_contracts/'.$id, $data);

            if (in_array($put_data->code, [200, 201])) {
                $this->Flash->success('Data successfully edited.');
                return $this->redirect($this->referer());
            }
        }

        $response = $this->req('GET', '/therapist');
        $result = $response->json['data'];
        $therapist = [];

        if (in_array($response->code, [200, 201])) {
            $therapist = $result['data'];
        }

        $response = $this->req('GET', '/therapist_session');
        $result = $response->json['data'];
        $therapist_session = [];

        if (in_array($response->code, [200, 201])) {
            $therapist_session = $result['data'];
        }

        $therapist_contracts = [];

        $get_therapist_contracts = $this->req('GET', '/therapist_contracts/'.$id);

        if (in_array($get_therapist_contracts->code, [200, 201])) {
            $therapist_contracts = $get_therapist_contracts->json['data'];
        }

        $this->set(compact('therapist', 'therapist_session', 'therapist_contracts'));
    }

    /**
     *  delete method
     *  delete therapist contract process
     */
    public function delete($id = null)
    {
        if (is_numeric($id)) {
            $response = $this->req('DELETE', '/therapist_contracts/'.$id);

            if (in_array($response->code, [200, 201])) {
                $this->Flash->success('Data successfully deleted.');
            } else {
                $this->Flash->error('There was an error. Please try again.');
            }
        }

        return $this->redirect($this->referer());
    }

    /**
     *  saveTherapistContract method
     *  save therapist contract from ajax
     */
    public function saveTherapistContract()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $contract_id = $this->request->data('contract_id');
            $therapist_id = $this->request->data('therapist_id');
            $therapist_session_id = $this->request->data('therapist_session_id');

            $data = [
                'contract_id' => $contract_id,
                'therapist_id' => $therapist_id,
                'therapist_session_id' => $therapist_session_id
            ];

            $post_data = $this->req('POST', '/therapist_contracts', $data);

            $therapist_contracts = $post_data->json;
            echo json_encode($therapist_contracts);
        }
    }

    /**
     *  getTherapistSessions method
     *  provide therapist sessions dropdown data based on given therapist_type_id
     */
    public function getTherapistSessions()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $therapist_type_id = $this->request->data('therapist_type_id');

            $getTherapistSessions = $this->req('GET', '/therapist_session/therapist_type_id/'.$therapist_type_id);

            $therapist_session = $getTherapistSessions->json;
            echo json_encode($therapist_session);
        }
    }
    
    /**
     *  getTherapist method
     *  provide therapist dropdwon data based
     */
    public function getTherapist()
    {
        $this->autoRender = false;

        $getTherapist = $this->req('GET', '/therapist');

        $therapist = $getTherapist->json['data'];
        echo json_encode($therapist);
    }
}