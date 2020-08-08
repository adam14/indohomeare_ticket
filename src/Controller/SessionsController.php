<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class SessionsController extends AppController
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
            'saveAjax'
        ];

        if (in_array($action, $allowed_method)) {
            return true;
        }

        $this->Flash->error('You\'re not worthy.');
    }

    /**
     *  index method
     *  index process
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

        $response = $this->req('GET', '/sessions'.$conditions);
        $result = $response->json;
        $total_data = 0;
        $sessions = [];
        $paging = [];
        $paging['current'] = 0;

        if (in_array($response->code, [200, 201])) {
            $total_data = $result['data']['total'];
            $sessions = $result['data']['data'];
            $paging = $result['data']['current_page'];
        }

        $get_service_sessions = $this->req('GET', '/service_sessions');
        $result_service_sessions = $get_service_sessions->json;
        $count = $result_service_sessions['data']['total'];

        $all_service_sessions = $this->req('GET', '/service_sessions?limit='.$count);
        $result_all_service_sessions = $all_service_sessions->json;
        $service_sessions = [];

        if (in_array($all_service_sessions->code, [200, 201])) {
            $service_sessions = $result_all_service_sessions['data']['data'];
        }

        $this->set(compact('sessions', 'service_sessions', 'total_data', 'paging', 'data_limit'));
    }

    /**
     *  add method
     *  add medic tools page and process
     */
    public function add()
    {
        $this->viewBuilder()->layout('modal');

        $count = $this->req('GET', '/services');
        $count = $count->json['data']['total'];

        $response = $this->req('GET', '/services?limit='.$count);
        $result = $response->json['data'];
        $services = [];

        if (in_array($response->code, [200, 201])) {
            $services = $result['data'];
        }

        $this->set(compact('services'));
    }

    /**
     *  saveAjax Method
     *  save sesi data with ajax
     */
    public function saveAjax()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $name = $this->request->data('name');
            $service_id = $this->request->data('service_id');

            if (empty($service_id)) {
                $data = [
                    'name' => $name
                ];
                $post_data = $this->req('POST', '/sessions', $data);

                $save_session = $post_data->json;
                echo json_encode($save_session);
            } else {
                echo "Simpan Berserta Service Sesi";
            }
        }
    }
}