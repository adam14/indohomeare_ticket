<?php
namespace App\Controller;

use App\Controller\AppController;

class NurseContractsController extends AppController
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
            'delete',
            'edit',
            'getNurse',
            'getNurseSessions',
            'saveNurseContract'
        ];

        if (in_array($action, $allowed_method)) {
            return true;
        }

        $this->Flash->error('You\'re not worthy.');
    }

    /**
     *  add method
     *  add nurse contracts page and process
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
            $nurse_id = $this->request->data('nurse_id');
            $nurse_session_id = $this->request->data('nurse_session_id');

            if (empty($contract_id) || empty($nurse_id) || empty($nurse_session_id)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'contract_id' => $contract_id,
                'nurse_id' => $nurse_id,
                'nurse_session_id' => $nurse_session_id
            ];

            $post_data = $this->req('POST', '/nurse_contracts', $data);

            if (in_array($post_data->code, [200, 201])) {
                $this->Flash->success('The data has been saved.');
            } else {
                $this->Flash->error('The data could not be save. Please, try again.');
            }

            return $this->redirect($this->referer());
        }

        $response = $this->req('GET', '/nurses');
        $result = $response->json['data'];
        $nurses = [];

        if (in_array($response->code, [200, 201])) {
            $nurses = $result['data'];
        }

        $response = $this->req('GET', '/nurse_sessions');
        $result = $response->json['data'];
        $nurse_sessions = [];

        if (in_array($response->code, [200, 201])) {
            $nurse_sessions = $result['data'];
        }

        $this->set(compact('id', 'nurses', 'nurse_sessions'));
    }

    /**
     *  edit method
     *  edit nurse contract page and process
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
            $nurse_id = $this->request->data('nurse_id');
            $nurse_session_id = $this->request->data('nurse_session_id');

            if (empty($contract_id) || empty($nurse_id) || empty($nurse_session_id)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'contract_id' => $contract_id,
                'nurse_id' => $nurse_id,
                'nurse_session_id' => $nurse_session_id,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $put_data = $this->req('PUT', '/nurse_contracts/'.$id, $data);

            if (in_array($put_data->code, [200, 201])) {
                $this->Flash->success('Data successfully edited.');
                return $this->redirect($this->referer());
            }
        }

        $response = $this->req('GET', '/nurses');
        $result = $response->json['data'];
        $nurses = [];

        if (in_array($response->code, [200, 201])) {
            $nurses = $result['data'];
        }

        $response = $this->req('GET', '/nurse_sessions');
        $result = $response->json['data'];
        $nurse_sessions = [];

        if (in_array($response->code, [200, 201])) {
            $nurse_sessions = $result['data'];
        }

        $nurse_contracts = [];

        $get_nurse_contracts = $this->req('GET', '/nurse_contracts/'.$id);
        // $get_nurse_contracts = $this->req('GET', '/nurse_contracts?contract_id='.$id);

        if (in_array($get_nurse_contracts->code, [200, 201])) {
            $nurse_contracts = $get_nurse_contracts->json['data'];
        }

        $this->set(compact('nurses', 'nurse_sessions', 'nurse_contracts'));
    }

    /**
     *  delete method
     *  delete nurse contract process
     */
    public function delete($id = null)
    {
        if (is_numeric($id)) {
            $response = $this->req('DELETE', '/nurse_contracts/'.$id);

            if (in_array($response->code, [200, 201])) {
                $this->Flash->success('Data successfully deleted.');
            } else {
                $this->Flash->error('There was an error. Please try again.');
            }
        }

        return $this->redirect($this->referer());
    }

    /**
     *  saveNurseContract method
     *  save nurse contract from ajax
     */
    public function saveNurseContract()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $contract_id = $this->request->data('contract_id');
            $nurse_id = $this->request->data('nurse_id');
            $nurse_session_id = $this->request->data('nurse_session_id');

            $data = [
                'contract_id' => $contract_id,
                'nurse_id' => $nurse_id,
                'nurse_session_id' => $nurse_session_id
            ];

            $post_data = $this->req('POST', '/nurse_contracts', $data);

            $nurse_contracts = $post_data->json;
            echo json_encode($nurse_contracts);
        }
    }

    /**
     *  getNurseSessions method
     *  provide nurse sessions dropdown data based on given nurse_category_id
     */
    public function getNurseSessions()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $nurse_category_id = $this->request->data('nurse_category_id');

            $getNurseSessions = $this->req('GET', '/nurse_sessions/nurse_category_id/'.$nurse_category_id);

            $nurse_sessions = $getNurseSessions->json;
            echo json_encode($nurse_sessions);
        }
    }
    
    /**
     *  getNurse method
     *  provide nurse dropdwon data based
     */
    public function getNurse()
    {
        $this->autoRender = false;

        $getNurse = $this->req('GET', '/nurses');

        $nurses = $getNurse->json['data'];
        echo json_encode($nurses);
    }
}
