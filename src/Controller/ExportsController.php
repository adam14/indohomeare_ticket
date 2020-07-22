<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class ExportsController extends AppController
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
            'index'
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
        $this->viewBuilder()->layout('invoice');

        if ($this->request->is('post')) {
            $disable_date = $this->request->data('disable_date');
            $start_date = $this->request->data('start_date');
            $end_date = $this->request->data('end_date');

            $current_date = date('Y-m-d');

            $start_check = strtotime($start_date);
            $end_check = strtotime($end_date);
            $current_check = strtotime($current_date);
            
            $start_date = ($start_check == false || $start_check > $current_check) ? strtotime(date('Y-m-01')) : $start_check;
            $end_date = ($end_check == false || $end_check > $current_check) ? strtotime(date('Y-m-d')) : $end_check;

            /** Report Nurse */
            $response = $this->req('GET', '/reports/nurses?start='.$start_date.'&end='.$end_date);
            $result = $response->json['data'];
            $nurses = [];
            
            if (in_array($response->code, [200, 201])) {
                $nurses = $result;
            }
            /** End */

            /** Report Medic Tool */
            $response = $this->req('GET', '/reports/medic_tools?start='.$start_date.'&end='.$end_date);
            $result = $response->json['data'];
            $medic_tools = [];

            if (in_array($response->code, [200, 201])) {
                $medic_tools = $result;
            }
            /** End */

            /** Report Therapist */
            $response = $this->req('GET', '/reports/therapists?start='.$start_date.'&end='.$end_date);
            $result = $response->json['data'];
            $therapists = [];

            if (in_array($response->code, [200, 201])) {
                $therapists = $result;
            }
            /** End */

            /** Report Transport */
            $response = $this->req('GET', '/reports/transports?start='.$start_date.'&end='.$end_date);
            $result = $response->json['data'];
            $transports = [];

            if (in_array($response->code, [200, 201])) {
                $transports = $result;
            }
            /** End */

            /** Report Event */
            $response = $this->req('GET', '/reports/events?start='.$start_date.'&end='.$end_date);
            $result = $response->json['data'];
            $events = [];

            if (in_array($response->code, [200, 201])) {
                $events = $result;
            }
            /** End */

            $this->set(compact('disable_date', 'start_date', 'end_date', 'nurses', 'medic_tools', 'therapists', 'transports', 'events'));
        }
    }
}