<?php
namespace App\Controller;

use App\Controller\AppController;

class ContractTransportController extends AppController
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
            'getTransport',
            'saveTransportContract'
        ];

        if (in_array($action, $allowed_method)) {
            return true;
        }

        $this->Flash->error('You\'re not worthy.');
    }

    /**
     *  add method
     *  add transport contract page and process
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
            $transport_time_id = $this->request->data('transport_time_id');
            $distance = $this->request->data('distance');

            if (empty($contract_id) || empty($transport_time_id) || empty($distance)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'contract_id' => $contract_id,
                'transport_time_id' => $transport_time_id,
                'distance' => $distance
            ];

            $post_data = $this->req('POST', '/transport_contracts', $data);

            if (in_array($post_data->code, [200, 201])) {
                $this->Flash->success('The data has been saved.');
            } else {
                $this->Flash->error('The data could not be save. Please, try again.');
            }

            return $this->redirect($this->referer());
        }

        $response = $this->req('GET', '/transport_times');
        $result = $response->json['data'];
        $transport_times = [];

        if (in_array($response->code, [200, 201])) {
            $transport_times = $result['data'];
        }

        $this->set(compact('id', 'transport_times'));
    }

    /**
     *  edit method
     *  edit transport contract page and process
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
            $transport_time_id = $this->request->data('transport_time_id');
            $distance = $this->request->data('distance');

            if (empty($contract_id) || empty($transport_time_id) || empty($distance)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'contract_id' => $contract_id,
                'transport_time_id' => $transport_time_id,
                'distance' => $distance,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $put_data = $this->req('PUT', '/transport_contracts/'.$id, $data);

            if (in_array($put_data->code, [200, 201])) {
                $this->Flash->success('Data successfully edited.');
                return $this->redirect($this->referer());
            }
        }

        $response = $this->req('GET', '/transport_times');
        $result = $response->json['data'];
        $transport_times = [];

        if (in_array($response->code, [200, 201])) {
            $transport_times = $result['data'];
        }

        $transport_contracts = [];

        $get_transport_contracts = $this->req('GET', '/transport_contracts/'.$id);

        if (in_array($get_transport_contracts->code, [200, 201])) {
            $transport_contracts = $get_transport_contracts->json['data'];
        }

        $this->set(compact('transport_contracts', 'transport_times'));
    }

    /**
     *  delete method
     *  delete transport contract process
     */
    public function delete($id = null)
    {
        if (is_numeric($id)) {
            $response = $this->req('DELETE', '/transport_contracts/'.$id);

            if (in_array($response->code, [200, 201])) {
                $this->Flash->success('Data successfully deleted.');
            } else {
                $this->Flash->error('There was an error. Please try again.');
            }
        }

        return $this->redirect($this->referer());
    }

    /**
     *  saveTransportContract method
     *  save transport contract from ajax
     */
    public function saveTransportContract()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $contract_id = $this->request->data('contract_id');
            $transport_time_id = $this->request->data('transport_time_id');
            $distance = $this->request->data('distance');

            $data = [
                'contract_id' => $contract_id,
                'transport_time_id' => $transport_time_id,
                'distance' => $distance
            ];

            $post_data = $this->req('POST', '/transport_contracts', $data);

            $transport_contracts = $post_data->json;
            echo json_encode($transport_contracts);
        }
    }
    
    /**
     *  getTransport method
     *  provide transport dropdwon data based
     */
    public function getTransport()
    {
        $this->autoRender = false;

        $getTransport = $this->req('GET', '/transport_times');

        $transport_times = $getTransport->json['data'];
        echo json_encode($transport_times);
    }
}