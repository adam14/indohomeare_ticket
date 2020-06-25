<?php
namespace App\Controller;

use App\Controller\AppController;

class PatientController extends AppController
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
        $conditions .= '$order=id';

        $response = $this->req('GET', '/patients'.$conditions);
        $result = $response->json;
        $total_data = 0;
        $patients = [];
        $paging = [];
        $paging['current'] = 0;

        if (in_array($response->code, [200, 201])) {
            $total_data = $result['data']['total'];
            $patients = $result['data']['data'];
            $paging = $result['data']['current_page'];
        }

        $this->set(compact('patients', 'total_data', 'paging', 'data_limit'));
    }

    /**
     *  add method
     *  add patient page and process
     */
    public function add()
    {
        $this->viewBuilder()->layout('modal');

        if ($this->request->is('post')) {
            $fullname = htmlentities($this->request->data('fullname'));
            $pj_id = $this->request->data('pj_id');

            if (empty($fullname) || empty($pj_id)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'fullname' => $fullname,
                'pj_id' => $pj_id
            ];

            $post_data = $this->req('POST', '/patients', $data);

            if (in_array($post_data->code, [200, 201])) {
                $this->Flash->success('The data has been saved.');
            } else {
                $this->Flash->error('The data could not be save. Please, try again.');
            }

            return $this->redirect($this->referer());
        }

        $response = $this->req('GET', '/pjs');
        $result = $response->json['data'];
        $pjs = [];

        if  (in_array($response->code, [200, 201])) {
            $pjs = $result['data'];
        }

        $this->set(compact('pjs'));
    }

    /**
     *  edit method
     *  edit patient page and process
     */
    public function edit($id = null)
    {
        if (!is_numeric($id)) {
            $this->autoRender = false;
            echo 'There was an error';
        }

        $this->viewBuilder()->layout('modal');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $fullname = htmlentities($this->request->data('fullname'));
            $pj_id = $this->request->data('pj_id');

            if (empty($fullname) || empty($pj_id)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'fullname' => $fullname,
                'pj_id' => $pj_id,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $put_data = $this->req('PUT', '/patients/'.$id, $data);

            if (in_array($put_data->code, [200, 201])) {
                $this->Flash->success('Data successfully edited.');
                return $this->redirect($this->referer());
            }
        }

        $response = $this->req('GET', '/pjs');
        $result = $response->json['data'];
        $pjs = [];

        if (in_array($response->code, [200, 201])) {
            $pjs = $result['data'];
        }

        $patients = [];

        $get_patients = $this->req('GET', '/patients/'.$id);

        if (in_array($get_patients->code, [200, 201])) {
            $patients = $get_patients->json['data'];
        }

        $this->set(compact('patients', 'pjs'));
    }

    /**
     *  delete method
     *  delete patient process
     */
    public function delete($id = null)
    {
        if (is_numeric($id)) {
            $response = $this->req('DELETE', '/patients/'.$id);

            if (in_array($response->code, [200, 201])) {
                $this->Flash->success('Data successfully deleted.');
            } else {
                $this->Flash->error('There was an error. Please try again.');
            }
        }

        return $this->redirect($this->referer());
    }
}