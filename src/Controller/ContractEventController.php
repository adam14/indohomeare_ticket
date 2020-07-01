<?php
namespace App\Controller;

use App\Controller\AppController;

class ContractEventController extends AppController
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
            'enable',
            'disable',
            'delete',
            'saveEventContract'
        ];

        if (in_array($action, $allowed_method)) {
            return true;
        }

        $this->Flash->error('You\'re not worthy.');
    }

    /**
     *  add method
     *  add contract event page and process
     */
    public function add($id)
    {
        if (!is_numeric($id)) {
            $this->autoRender = false;
			echo 'There was an error.';
        }

        $this->viewBuilder()->layout('modal');

        if ($this->request->is('post')) {
            $event_name = htmlentities($this->request->data('event_name'));
            $contract_id = $this->request->data('contract_id');
            $price = $this->request->data('price');

            if (empty($event_name) || empty($contract_id) || empty($price)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'contract_id' => $contract_id,
                'event_name' => $event_name,
                'price' => $price
            ];

            $post_data = $this->req('POST', '/event_contracts', $data);

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
     *  edit contract event page and process
     */
    public function edit($id = null)
    {
        if (!is_numeric($id)) {
            $this->autoRender = false;
            echo 'There was an error';
        }

        $this->viewBuilder()->layout('modal');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $event_name = htmlentities($this->request->data('event_name'));
            $contract_id = $this->request->data('contract_id');
            $price = $this->request->data('price');

            if (empty($event_name) || empty($price)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'contract_id' => $contract_id,
                'event_name' => $event_name,
                'price' => $price,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $put_data = $this->req('PUT', '/event_contracts/'.$id, $data);

            if (in_array($put_data->code, [200, 201])) {
                $this->Flash->success('Data successfully edited.');
                return $this->redirect($this->referer());
            }
        }

        $event_contracts = [];

        $get_event_contracts = $this->req('GET', '/event_contracts/'.$id);

        if (in_array($get_event_contracts->code, [200, 201])) {
            $event_contracts = $get_event_contracts->json['data'];
        }

        $this->set(compact('event_contracts'));
    }

    /**
     *  delete method
     *  delete contract event process
     */
    public function delete($id = null)
    {
        if (is_numeric($id)) {
            $response = $this->req('DELETE', '/event_contracts/'.$id);

            if (in_array($response->code, [200, 201])) {
                $this->Flash->success('Data successfully deleted.');
            } else {
                $this->Flash->error('There was an error. Please try again.');
            }
        }

        return $this->redirect($this->referer());
    }

    /**
     *  saveEventContract method
     *  save event contract from ajax
     */
    public function saveEventContract()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $contract_id = $this->request->data('contract_id');
            $event_name = $this->request->data('event_name');
            $price = $this->request->data('price');

            $data = [
                'contract_id' => $contract_id,
                'event_name' => $event_name,
                'price' => $price
            ];

            $post_data = $this->req('POST', '/event_contracts', $data);

            $event_contracts = $post_data->json;
            echo json_encode($event_contracts);
        }
    }
}