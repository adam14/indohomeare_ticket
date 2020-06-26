<?php
namespace App\Controller;

use App\Controller\AppController;

class MedicToolSessionsController extends AppController
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

        $response = $this->req('GET', '/medic_tool_sessions'.$conditions);
        $result = $response->json;
        $total_data = 0;
        $medic_tool_sessions = [];
        $paging = [];
        $paging['current'] = 0;

        if (in_array($response->code, [200, 201])) {
            $total_data = $result['data']['total'];
            $medic_tool_sessions = $result['data']['data'];
            $paging = $result['data']['current_page'];
        }

        $this->set(compact('medic_tool_sessions', 'total_data', 'paging', 'data_limit'));
    }

    /**
     *  add method
     *  add medic tools session page and process
     */
    public function add()
    {
        $this->viewBuilder()->layout('modal');

        if ($this->request->is('post')) {
            $medic_tool_id = $this->request->data('medic_tool_id');
            $price = $this->request->data('price');

            if (empty($medic_tool_id) || empty($price)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'medic_tool_id' => $medic_tool_id,
                'price' => $price
            ];

            $post_data = $this->req('POST', '/medic_tool_sessions', $data);

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

        $this->set(compact('medic_tools'));
    }

    /**
     *  edit method
     *  edit medic tools sessions page and process
     */
    public function edit($id = null)
    {
        if (!is_numeric($id)) {
            $this->autoRender = false;
            echo 'There was an error';
        }

        $this->viewBuilder()->layout('modal');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $medic_tool_id = $this->request->data('medic_tool_id');
            $price = $this->request->data('price');

            if (empty($medic_tool_id) || empty($price)) {
                $this->Flash->error('Please complete the form.');
                return $this->redirect($this->referer());
            }

            $data = [
                'medic_tool_id' => $medic_tool_id,
                'price' => $price,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $put_data = $this->req('PUT', '/medic_tool_sessions/'.$id, $data);

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

        $medic_tool_sessions = [];

        $get_medic_tool_sessions = $this->req('GET', '/medic_tool_sessions/'.$id);

        if (in_array($get_medic_tool_sessions->code, [200, 201])) {
            $medic_tool_sessions = $get_medic_tool_sessions->json['data'];
        }

        $this->set(compact('medic_tools', 'medic_tool_sessions'));
    }

    /**
     *  delete method
     *  delete medic tools session process
     */
    public function delete($id = null)
    {
        if (is_numeric($id)) {
            $response = $this->req('DELETE', '/medic_tool_sessions/'.$id);

            if (in_array($response->code, [200, 201])) {
                $this->Flash->success('Data successfully deleted.');
            } else {
                $this->Flash->error('There was an error. Please try again.');
            }
        }

        return $this->redirect($this->referer());
    }
}