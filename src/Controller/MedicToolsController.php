<?php
namespace App\Controller;

use App\Controller\AppController;

class MedicToolsController extends AppController
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

        $response = $this->req('GET', '/medic_tools'.$conditions);
        $result = $response->json;
        $total_data = 0;
        $medic_tools = [];
        $paging = [];
        $paging['current'] = 0;

        if (in_array($response->code, [200, 201])) {
            $total_data = $result['data']['total'];
            $medic_tools = $result['data']['data'];
            $paging = $result['data']['current_page'];
        }

        $this->set(compact('medic_tools', 'total_data', 'paging', 'data_limit'));
    }

    /**
     *  add method
     *  add medic tools page and process
     */
    public function add()
    {
        $this->viewBuilder()->layout('modal');

        if ($this->request->is('post')) {
            $name = htmlentities($this->request->data('name'));
            $medic_tool_category = $this->request->data('medic_tool_category');

            if (empty($name) || empty($medic_tool_category)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'name' => $name,
                'medic_tool_category' => $medic_tool_category
            ];

            $post_data = $this->req('POST', '/medic_tools', $data);

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
     *  edit medic tools page and process
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
            $medic_tool_category = $this->request->data('medic_tool_category');

            if (empty($name) || empty($medic_tool_category)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'name' => $name,
                'medic_tool_category' => $medic_tool_category,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $put_data = $this->req('PUT', '/medic_tools/'.$id, $data);

            if (in_array($put_data->code, [200, 201])) {
                $this->Flash->success('Data successfully edited.');
                return $this->redirect($this->referer());
            }
        }

        $medic_tools = [];

        $get_medic_tools = $this->req('GET', '/medic_tools/'.$id);

        if (in_array($get_medic_tools->code, [200, 201])) {
            $medic_tools = $get_medic_tools->json['data'];
        }

        $this->set(compact('medic_tools'));
    }

    /**
     *  delete method
     *  delete medic tools process
     */
    public function delete($id = null)
    {
        if (is_numeric($id)) {
            $response = $this->req('DELETE', '/medic_tools/'.$id);

            if (in_array($response->code, [200, 201])) {
                $this->Flash->success('Data successfully deleted.');
            } else {
                $this->Flash->error('There was an error. Please try again.');
            }
        }

        return $this->redirect($this->referer());
    }
}