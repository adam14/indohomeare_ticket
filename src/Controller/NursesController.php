<?php
namespace App\Controller;

use App\Controller\AppController;

class NursesController extends AppController
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

        $response = $this->req('GET', '/nurses'.$conditions);
        $result = $response->json;
        $total_data = 0;
        $nurses = [];
        $paging = [];
        $paging['current'] = 0;

        if (in_array($response->code, [200, 201])) {
            $total_data = $result['data']['total'];
            $nurses = $result['data']['data'];
            $paging = $result['data']['current_page'];
        }

        $this->set(compact('nurses', 'total_data', 'paging', 'data_limit'));
    }

    /**
     *  add method
     *  add nurses page and process
     */
    public function add()
    {
        $this->viewBuilder()->layout('modal');

        if ($this->request->is('post')) {
            $fullname = htmlentities($this->request->data('fullname'));
            $nurse_category_id = $this->request->data('nurse_category_id');

            if (empty($fullname) || empty($nurse_category_id)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'fullname' => $fullname,
                'nurse_category_id' => $nurse_category_id
            ];

            $post_data = $this->req('POST', '/nurses', $data);

            if (in_array($post_data->code, [200, 201])) {
                $this->Flash->success('The data has been saved.');
            } else {
                $this->Flash->error('The data could not be save. Please, try again.');
            }

            return $this->redirect($this->referer());
        }

        $response = $this->req('GET', '/nurse_categories');
        $result = $response->json['data'];
        $nurses_categories = [];

        if  (in_array($response->code, [200, 201])) {
            $nurses_categories = $result['data'];
        }

        $this->set(compact('nurses_categories'));
    }

    /**
     *  edit method
     *  edit nurses page and process
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
            $nurse_category_id = $this->request->data('nurse_category_id');

            if (empty($fullname) || empty($nurse_category_id)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'fullname' => $fullname,
                'nurse_category_id' => $nurse_category_id,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $put_data = $this->req('PUT', '/nurses/'.$id, $data);

            if (in_array($put_data->code, [200, 201])) {
                $this->Flash->success('Data successfully edited.');
                return $this->redirect($this->referer());
            }
        }

        $response = $this->req('GET', '/nurse_categories');
        $result = $response->json['data'];
        $nurses_categories = [];

        if (in_array($response->code, [200, 201])) {
            $nurses_categories = $result['data'];
        }

        $nurses = [];

        $get_nurses = $this->req('GET', '/nurses/'.$id);

        if (in_array($get_nurses->code, [200, 201])) {
            $nurses = $get_nurses->json['data'];
        }

        $this->set(compact('nurses', 'nurses_categories'));
    }

    /**
     *  delete method
     *  delete nurses process
     */
    public function delete($id = null)
    {
        if (is_numeric($id)) {
            $response = $this->req('DELETE', '/nurses/'.$id);

            if (in_array($response->code, [200, 201])) {
                $this->Flash->success('Data successfully deleted.');
            } else {
                $this->Flash->error('There was an error. Please try again.');
            }
        }

        return $this->redirect($this->referer());
    }
}