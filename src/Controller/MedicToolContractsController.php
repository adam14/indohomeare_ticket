<?php
namespace App\Controller;

use App\Controller\AppController;

class MedicToolContractsController extends AppController
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
            'getMedicToolSessions',
            'delete'
        ];

        if (in_array($action, $allowed_method)) {
            return true;
        }

        $this->Flash->error('You\'re not worthy.');
    }

    /**
     *  add method
     *  add medic tools contracts page and process
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
            $medic_tool_id = $this->request->data('medic_tool_id');
            $medic_tool_session_id = $this->request->data('medic_tool_session_id');

            if (empty($contract_id) || empty($medic_tool_id) || empty($medic_tool_session_id)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'contract_id' => $contract_id,
                'medic_tool_id' => $medic_tool_id,
                'medic_tool_session_id' => $medic_tool_session_id
            ];

            $post_data = $this->req('POST', '/medic_tool_contracts', $data);

            if (in_array($post_data->code, [200, 201])) {
                $this->Flash->success('The data has been saved.');
            } else {
                $this->Flash->error('The data could not be save. Please, try again.');
            }

            return $this->redirect($this->referer());
        }

        $response = $this->req('GET', '/medic_tools');
        $result = $response->json['data'];
        $medic_tools = [];

        if (in_array($response->code, [200, 201])) {
            $medic_tools = $result['data'];
        }

        $this->set(compact('id', 'medic_tools'));
    }

    /**
     *  edit method
     *  edit medic tools contract page and process
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
            $medic_tool_id = $this->request->data('medic_tool_id');
            $medic_tool_session_id = $this->request->data('medic_tool_session_id');

            if (empty($contract_id) || empty($medic_tool_id) || empty($medic_tool_session_id)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'contract_id' => $contract_id,
                'medic_tool_id' => $medic_tool_id,
                'medic_tool_session_id' => $medic_tool_session_id,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $put_data = $this->req('PUT', '/medic_tool_contracts/'.$id, $data);

            if (in_array($put_data->code, [200, 201])) {
                $this->Flash->success('Data successfully edited.');
                return $this->redirect($this->referer());
            }
        }

        $response = $this->req('GET', '/medic_tools');
        $result = $response->json['data'];
        $medic_tools = [];

        if (in_array($response->code, [200, 201])) {
            $medic_tools = $result['data'];
        }

        $medic_tool_contracts = [];

        $get_medic_tool_contracts = $this->req('GET', '/medic_tool_contracts/'.$id);

        if (in_array($get_medic_tool_contracts->code, [200, 201])) {
            $medic_tool_contracts = $get_medic_tool_contracts->json['data'];
        }

        $this->set(compact('medic_tools', 'medic_tool_contracts'));
    }

    /**
     *  delete method
     *  delete medic tool contracts process
     */
    public function delete($id = null)
    {
        if (is_numeric($id)) {
            $response = $this->req('DELETE', '/medic_tool_contracts/'.$id);

            if (in_array($response->code, [200, 201])) {
                $this->Flash->success('Data successfully deleted.');
            } else {
                $this->Flash->error('There was an error. Please try again.');
            }
        }

        return $this->redirect($this->referer());
    }

    /**
     *  getMedicToolSessions method
     *  provide medic tool sessions dropdown data based on given medic_tool_id
     */
    public function getMedicToolSessions()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $medic_tool_id = $this->request->data('medic_tool_id');

            $getMedicToolSessions = $this->req('GET', '/medic_tool_sessions/medic_tool/'.$medic_tool_id);

            $medic_tool_sessions = $getMedicToolSessions->json;
            echo json_encode($medic_tool_sessions);
        }
    }
}