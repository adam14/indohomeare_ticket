<?php
namespace App\Controller;

use App\Controller\AppController;

class ContractHistoriesController extends AppController
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
            'saveHistory'
        ];

        if (in_array($action, $allowed_method)) {
            return true;
        }

        $this->Flash->error('You\'re not worthy.');
    }

    /**
     *  add method
     *  add contract histories page and process
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
            $description = $this->request->data('description');

            if (empty($contract_id) || empty($description)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'contract_id' => $contract_id,
                'description' => $description,
                'user_id' => $this->request->session()->read('Auth.User.id')
            ];

            $post_data = $this->req('POST', '/contract_histories', $data);

            if (in_array($post_data->code, [200, 201])) {
                $this->Flash->success('The data has been saved.');
            } else {
                $this->Flash->error('The data could not be save. Please, try again.');
            }

            return $this->redirect($this->referer());
        }

        $this->set(compact('id'));
    }

    /**
     *  edit method
     *  edit contract histories page and process
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
            $description = $this->request->data('description');

            if (empty($contract_id) || empty($description)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'contract_id' => $contract_id,
                'description' => $description,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $put_data = $this->req('PUT', '/contract_histories/'.$id, $data);

            if (in_array($put_data->code, [200, 201])) {
                $this->Flash->success('Data successfully edited.');
                return $this->redirect($this->referer());
            }
        }

        $contract_histories = [];

        $get_contract_histories = $this->req('GET', '/contract_histories/'.$id);

        if (in_array($get_contract_histories->code, [200, 201])) {
            $contract_histories = $get_contract_histories->json['data'];
        }

        $this->set(compact('contract_histories'));
    }

    /**
     *  delete method
     *  delete contract histories process
     */
    public function delete($id = null)
    {
        if (is_numeric($id)) {
            $response = $this->req('DELETE', '/contract_histories/'.$id);

            if (in_array($response->code, [200, 201])) {
                $this->Flash->success('Data successfully deleted.');
            } else {
                $this->Flash->error('There was an error. Please try again.');
            }
        }

        return $this->redirect($this->referer());
    }

    /**
     *  saveHistory method
     *  save history contract with ajax
     */
    public function saveHistory()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $contract_id = $this->request->data('contract_id');
            $description = $this->request->data('description');

            $data = [
                'contract_id' => $contract_id,
                'description' => $description,
                'user_id' => $this->request->session()->read('Auth.User.id')
            ];

            $post_data = $this->req('POST', '/contract_histories', $data);

            $saveHistory = $post_data->json;
            echo json_encode($saveHistory);
        }
    }
}