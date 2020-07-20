<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class HomeController extends AppController
{
    /**
     *  beforeFilter method
     *  this function is executed before every action in the controller
     *  @param Event $event
     *  @return void
     */
    public function beforeFilter(\Cake\Event\Event $event)
    {
    }

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
            'getByStatus',
            'getByService',
        ];
		
		if (in_array($action, $allowed_method)) {
			return true;
		}
		
		$this->Flash->error('You\'re not worthy.');
    }

    /**
     *  index method
     *  dashboard page
     */
    public function index()
    {
        $session = $this->request->session();
        $date = [];
        $draft = [];
        $deal = [];
        $done = [];
        $no_response = [];
        $cancel = [];

        $date_service = [];
        $nurse_service = [];
        $medic_tool_service = [];
        $therapist_service = [];
        $event_service = [];
        $transport_service = [];

        $response = $this->req('GET', '/statistic/status?start='.strtotime(date('Y-m-01')).'&end='.strtotime(date('Y-m-d')));
        $result = $response->json['data'];
        if (in_array($response->code, [200, 201])) {
            foreach ($result as $value) {
                $date[] = date('Y-m-d', strtotime($value['date']));
                $draft[] = $value['draft'];
                $deal[] = $value['deal'];
                $done[] = $value['done'];
                $no_response[] = $value['no_response'];
                $cancel[] = $value['cancel'];
            }
        }

        $response = $this->req('GET', '/statistic/service?start='.strtotime(date('Y-m-01')).'&end='.strtotime(date('Y-m-d')));
        $result = $response->json['data'];
        if (in_array($response->code, [200, 201])) {
            foreach ($result as $value) {
                $date_service[] = date('Y-m-d', strtotime($value['date']));
                $nurse_service[] = $value['nurse_service'];
                $medic_tool_service[] = $value['medic_tool_service'];
                $therapist_service[] = $value['therapist_service'];
                $event_service[] = $value['event_service'];
                $transport_service[] = $value['transport_service'];
            }
        }

        $this->set(compact('date','draft', 'deal', 'done', 'no_response', 'cancel', 'date_service', 'nurse_service', 'medic_tool_service', 'therapist_service', 'event_service', 'transport_service'));
    }

    public function getByStatus()
    {
        $start = strtotime($this->request->data('start_date'));
        $end = strtotime($this->request->data('end_date'));
        $response = $this->req('GET', '/statistic/status?start='.$start.'&end='.$end);
        $result = $response->json['data'];
        if (in_array($response->code, [200, 201])) {
            foreach ($result as $value) {
                $date[] = date('Y-m-d', strtotime($value['date']));
                $draft[] = $value['draft'];
                $deal[] = $value['deal'];
                $done[] = $value['done'];
                $no_response[] = $value['no_response'];
                $cancel[] = $value['cancel'];
            }
        }

        $this->set(compact('date','draft', 'deal', 'done', 'no_response', 'cancel'));
    }

    public function getByService($param = null)
    {
        $start = strtotime($this->request->data('start_date'));
        $end = strtotime($this->request->data('end_date'));
        $response = $this->req('GET', '/statistic/service?start='.$start.'&end='.$end);
        $result = $response->json['data'];
        if (in_array($response->code, [200, 201])) {
            foreach ($result as $value) {
                $date_service[] = date('Y-m-d', strtotime($value['date']));
                $nurse_service[] = $value['nurse_service'];
                $medic_tool_service[] = $value['medic_tool_service'];
                $therapist_service[] = $value['therapist_service'];
                $event_service[] = $value['event_service'];
                $transport_service[] = $value['transport_service'];
            }
        }

        $this->set(compact('date_service','nurse_service', 'medic_tool_service', 'therapist_service', 'event_service', 'transport_service'));
    }
}