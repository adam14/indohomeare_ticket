<?php
namespace App\Controller;

use App\Controller\SecurityController;
use Cake\Event\Event;

class UsersController extends AppController
{
    /**
     *  beforeFilter method
     *  this function is executed before every action in the controller
     *  @param Event $event
     *  @return void
     */
    public function beforeFilter(\Cake\Event\Event $event)
    {
        $allowed_method = [
            'login',
            'logout'
        ];

        $this->Auth->allow($allowed_method);
    }

    public function login()
    {
        $this->viewBuilder()->layout('front');
        $session = $this->request->session();

        if ($session->check('Auth.User')) {
            return $this->redirect(['controller' => 'Home', 'action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $email = $this->request->data('email');
            $password = $this->request->data('password');
            
            $data = [
                'email' => $email,
                'password' => $password
            ];

            $response = $this->req('POST', '/login', $data);

            // if ($response->json['status'] == false) {
            //     $session->destroy();

            //     $this->Flash->error('Your email or password is incorrect.');
            //     return $this->redirect(['action' => 'login']);
            // }

            if ($response->json['status'] == true) {
                $result = $response->json;
                $access_token = $result['data']['token'];
				$session->write('Auth.User.token', $access_token);

                sleep(1);

                $response = $this->req('GET', '/users/'.$result['data']['id']);

                if ($response->code == 200) {
                    $result = $response->json;
                    $is_active = $result['data']['active'];

                    if ($is_active == 1) {
                        $this->Auth->setUser($result['data']);

                        // $Security = new SecurityController;
                        // $password = $Security->encode($data['password']);

                        $session->write('Auth.User.email', $data['email']);
						$session->write('Auth.User.password', $data['password']);
                        $session->write('Auth.User.token', $access_token);

                        return $this->redirect($this->Auth->redirectUrl());
                    }
                }
            }

            $session->destroy();

            $this->Flash->error('Your email or password is incorrect.');
            return $this->redirect(['action' => 'login']);
        }
    }

    public function logout()
    {
        $this->request->session()->destroy();
        $this->Flash->success('You are now loggedd out.');

        return $this->redirect(['action' => 'login']);
    }
}