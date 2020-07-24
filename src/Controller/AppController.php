<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use App\Controller\ModulesController;
use App\Controller\SecurityController;
use Cake\Event\Event;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Network\Http\Client;
use Cake\Network\Http\FormData;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        // $this->loadComponent('RequestHandler', [
        //     'enableBeforeRedirect' => false,
        // ]);
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('SocketIO');
        $this->loadComponent('Auth', [
            'authorize' => 'Controller',
            'authError' => 'Whoops you are not allowed to see that',
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'email' => 'email',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login',
            ],
            'loginRedirect' => [
                'controller' => 'Home',
                'action' => 'index'
            ],
            'unauthorizedRedirect' => $this->referer()
        ]);

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }

    /**
     *  Before render callback
     * 
     *  @param \Cake\Event\Event $event The beforeRender event.
     *  @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }

        $this->viewBuilder()->theme('Theme');
		$this->viewBuilder()->helpers([
			'Form',
			'MenuBuilder' => [
				'activeClass' => 'menu-top-active',
				'childrenClass' => 'dropdown',
				'wrapperClass' => 'dropdown-menu',
				'noLinkFormat' => '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">%s <span class="caret"></span></a>',
				'authModel' => 'User',
				'authField' => 'user_level_id'
			]
        ]);
        
        if ($this->request->session()->check('Auth.User')) {
            /**
			if (!$this->request->session()->check('Auth.User.modules')) {
				$response = $this->req('GET', '/user_level_modules/active?code=TICKET&user_level_id='.$this->request->session()->read('Auth.User.user_level_id').'&order=code');
				
				if ($response->code == 200) {
					$result = $response->json;
					$this->request->session()->write('Auth.User.modules', $result['data']);
				}
			}
			
			$Modules = new ModulesController;
			$menu = $Modules->menu();

            $this->set(compact('menu'));
            */

            $user_menu = $this->request->session()->read('Auth');


            $menu = [
                'menu-top' => [
                    [
                        'title' => 'Dashboard',
                        'url' => ['controller' => 'Home', 'action' => 'index']
                    ],
                    [
                        'title' => 'Kontrak',
                        'url' => ['controller' => 'Contracts', 'action' => 'index']
                    ],
                    [
                        'title' => 'Alkes',
                        'url' => ['controller' => 'MedicTools', 'action' => 'index']
                    ],
                    [
                        'title' => 'Terapi',
                        'url' => ['controller' => 'Therapist', 'action' => 'index']
                    ],
                    [
                        'title' => 'Perawat',
                        'url' => ['controller' => 'Nurses', 'action' => 'index']
                    ],
                    [
                        'title' => 'Transport',
                        'url' => ['controller' => 'TransportTime', 'action' => 'index']
                    ],
                    [
                        'title' => 'PJ',
                        'url' => ['controller' => 'Pjs', 'action' => 'index']
                    ],
                    [
                        'title' => 'Pasien',
                        'url' => ['controller' => 'Patient', 'action' => 'index']
                    ]
                ]
            ];

            if ($this->request->session()->read('Auth.User.role_id') != 1) {
                $menu = [
                    'menu-top' => [
                        [
                            'title' => 'Dashboard',
                            'url' => ['controller' => 'Home', 'action' => 'index']
                        ],
                        [
                            'title' => 'Kontrak',
                            'url' => ['controller' => 'Contracts', 'action' => 'index']
                        ],
                        [
                            'title' => 'PJ',
                            'url' => ['controller' => 'Pjs', 'action' => 'index']
                        ],
                        [
                            'title' => 'Pasien',
                            'url' => ['controller' => 'Patient', 'action' => 'index']
                        ]
                    ]
                ];
            }

            $this->set(compact('menu', 'user_menu'));
		}
    }

    public function req($method, $endpoint, $data = [], $token = false, $trial = 0)
    {
        $base_uri = Configure::read('base_uri_data');
        $request_config = [];
        $request_config['headers']['User-Agent'] = 'Ticketing-WebApp';

        if ($token == true) {
            $http = new Client($request_config);
            // $Security = new SecurityController;

            $data_user = [
                'email' => $this->request->session()->read('Auth.User.email'),
                'password' => $this->request->session()->read('Auth.User.password')
                // 'password' => $Security->decode($this->request->session()->read('Auth.User.password'))
            ];
            $response = $http->post($base_uri.'/login', $data_user);

            $result = [];

            if ($response->json['status'] == true) {
                $result = $response->json;
                $this->request->session()->write('Auth.User.token', $result['data']['token']);
                sleep(1);
            }
        }

        $access_token = $this->request->session()->read('Auth.User.token');
		
		if (!empty($access_token)) {
			$request_config['headers']['Authorization'] = 'Bearer '.$access_token;
        }
        
        if ($method == 'DELETE') {
            $request_config['headers']['X-CSRF-Token'] = json_encode($this->request->getParam('_csrfToken'));
        }

        $http = new Client($request_config);

        switch ($method) {
			case 'GET':
				$response = $http->get($base_uri.$endpoint);
				break;
			case 'POST':
				$response = $http->post($base_uri.$endpoint, $data);
				break;
			case 'PUT':
				$response = $http->put($base_uri.$endpoint, $data);
				break;
			case 'DELETE':
				$response = $http->delete($base_uri.$endpoint);
				break;
			default:
				$response = (object) ['code' => 500];
        }
        
        $attempt = $trial;
		$attempt++;

		$success_status = [200, 201];

		if (!in_array($response->code, $success_status) && $attempt <= 3) {
			$response = $this->req($method, $endpoint, $data, true, $attempt);
            return $response;
		}
		
		return $response;
    }

    public function isAuthorized($user)
    {
        return false;
    }
}
