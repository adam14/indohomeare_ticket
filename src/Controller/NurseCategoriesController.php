<?php
namespace App\Controller;

use App\Controller\AppController;

class NurseCategoriesController extends AppController
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

        $response = $this->req('GET', '/nurse_categories'.$conditions);
        $result = $response->json;
        $total_data = 0;
        $nurse_categories = [];
        $paging = [];
        $paging['current'] = 0;

        if (in_array($response->code, [200, 201])) {
            $total_data = $result['data']['total'];
            $nurse_categories = $result['data']['data'];
            $paging = $result['data']['current_page'];
        }

        $this->set(compact('nurse_categories', 'total_data', 'paging', 'data_limit'));
    }

    /**
     *  add method
     *  add nurse category page and process
     */
    public function add()
    {
        $this->viewBuilder()->layout('modal');

        if ($this->request->is('post')) {
            $name = htmlentities($this->request->data('name'));

            if (empty($name)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'name' => $name
            ];

            $post_data = $this->req('POST', '/nurse_categories', $data);

            if (in_array($post_data->code, [200, 201])) {
                $this->Flash->success('The data has been saved.');
            } else {
                $this->Flash->error('The data could not be save. Please, try again.');
            }

            return $this->redirect($this->referer());
        }
    }

    /**
     *  edit method
     *  edit nurse category page and process
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

            if (empty($name)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'name' => $name,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $put_data = $this->req('PUT', '/nurse_categories/'.$id, $data);

            if (in_array($put_data->code, [200, 201])) {
                $this->Flash->success('Data successfully edited.');
                return $this->redirect($this->referer());
            }
        }

        $nurse_categories = [];

        $get_nurse_categories = $this->req('GET', '/nurse_categories/'.$id);

        if (in_array($get_nurse_categories->code, [200, 201])) {
            $nurse_categories = $get_nurse_categories->json['data'];
        }

        $this->set(compact('nurse_categories'));
    }

    /**
     *  delete method
     *  delete nurse category process
     */
    public function delete($id = null)
    {
        if (is_numeric($id)) {
            $response = $this->req('DELETE', '/nurse_categories/'.$id);

            if (in_array($response->code, [200, 201])) {
                $this->Flash->success('Data successfully deleted.');
            } else {
                $this->Flash->error('There was an error. Please try again.');
            }
        }

        return $this->redirect($this->referer());
    }
}