<?php
namespace App\Controller;

use App\Controller\AppController;

class TherapistSessionsController extends AppController
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
            'delete'
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

        $response = $this->req('GET', '/therapist_session'.$conditions);
        $result = $response->json;
        $total_data = 0;
        $therapist_session = [];
        $paging = [];
        $paging['current'] = 0;

        if (in_array($response->code, [200, 201])) {
            $total_data = $result['data']['total'];
            $therapist_session = $result['data']['data'];
            $paging = $result['data']['current_page'];
        }

        $this->set(compact('therapist_session', 'total_data', 'paging', 'data_limit'));
    }

    /**
     *  add method
     *  add therapist sessions page and process
     */
    public function add()
    {
        $this->viewBuilder()->layout('modal');

        if ($this->request->is('post')) {
            $name = htmlentities($this->request->data('name'));
            $price = $this->request->data('price');
            $therapist_type_id = $this->request->data('therapist_type_id');

            if (empty($name) || empty($price) || empty($therapist_type_id)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'name' => $name,
                'price' => $price,
                'therapist_type_id' => $therapist_type_id
            ];

            $post_data = $this->req('POST', '/therapist_session', $data);

            if (in_array($post_data->code, [200, 201])) {
                $this->Flash->success('The data has been saved.');
            } else {
                $this->Flash->error('The data could not be save. Please, try again.');
            }

            return $this->redirect($this->referer());
        }

        $response = $this->req('GET', '/therapist_types');
        $result = $response->json['data'];
        $therapist_types = [];

        if (in_array($response->code, [200, 201])) {
            $therapist_types = $result['data'];
        }

        $this->set(compact('therapist_types'));
    }

    /**
     *  edit method
     *  edit therapist sessions page and process
     */
    public function edit($id = null)
    {
        if (!is_numeric($id)) {
            $this->autoRender = false;
            echo 'There was an error';
        }

        $this->viewBuilder()->layout('modal');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $name = htmlentities($this->request->data('name'));
            $price = $this->request->data('price');
            $therapist_type_id = $this->request->data('therapist_type_id');

            if (empty($name) || empty($price) || empty($therapist_type_id)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'name' => $name,
                'price' => $price,
                'therapist_type_id' => $therapist_type_id,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $put_data = $this->req('PUT', '/therapist_session/'.$id, $data);

            if (in_array($put_data->code, [200, 201])) {
                $this->Flash->success('Data successfully edited.');
                return $this->redirect($this->referer());
            }
        }

        $response = $this->req('GET', '/therapist_types');
        $result = $response->json['data'];
        $therapist_types = [];

        if (in_array($response->code, [200, 201])) {
            $therapist_types = $result['data'];
        }

        $therapist_session = [];

        $get_therapist_session = $this->req('GET', '/therapist_session/'.$id);

        if (in_array($get_therapist_session->code, [200, 201])) {
            $therapist_session = $get_therapist_session->json['data'];
        }

        $this->set(compact('therapist_session', 'therapist_types'));
    }

    /**
     *  delete method
     *  delete therapist sessions process
     */
    public function delete($id = null)
    {
        if (is_numeric($id)) {
            $response = $this->req('DELETE', '/therapist_session/'.$id);

            if (in_array($response->code, [200, 201])) {
                $this->Flash->success('Data successfully deleted.');
            } else {
                $this->Flash->error('There was an error. Please try again.');
            }
        }

        return $this->redirect($this->referer());
    }
}