<?php
namespace App\Controller;

class ModulesController extends AppController {
	/**
	 *  __generator method
	 *  generate module code withouut storing to array data type
	 */
	function __generator($user_modules) {
		foreach	($user_modules as $user_module) {
			yield $user_module['code'];
		}
	}
	
	/**
	 *  menu method
	 *  prepare menu for application based on user level
	 */
	public function menu()
	{
		/**
		$menu = [
			'menu-top' => [
				[
					'title' => 'Dashboard',
					'url' => ['controller' => 'Home', 'action' => 'index'],
				]
			]
		];
		 */

		$menu = [
			'menu-top' => []
		];

		if ($this->request->session()->read('Auth.User.user_level_id') != 6) {
			$menu['menu-top'][] = [
				'title' => 'Dashboard',
				'url' => ['controller' => 'Home', 'action' => 'index'],
			];
		}
		
		if ($this->request->session()->check('Auth.User.modules') && !$this->request->session()->check('Auth.User.menu')) {
			$user_modules = $this->request->session()->read('Auth.User.modules');

			if (!empty($user_modules)) {
				$module_codes = [];
				
				$module_settings = ['TICKET-11', 'TICKET-12', 'TICKET-13', 'TICKET-14', 'TICKET-15', 'TICKET-16', 'TICKET-17', 'TICKET-18', 'TICKET-19', 'TICKET-20', 'TICKET-21', 'TICKET-22', 'TICKET-23', 'TICKET-24'];
				$menu_settings = [];
				$generator_module = $this->__generator($user_modules);
				
				foreach ($generator_module as $module) {
					if (in_array($module, $module_settings)) {
						$menu_settings = [
							'title' => 'Settings',
							'children' => []
						];
						break;
					}
				}
				
				$user_modules = $this->__generator($user_modules);
				
				foreach ($user_modules as $user_module) {
					$module_codes[] = $user_module;
					
					if ($user_module == 'TICKET-01') {
						$menu['menu-top'][] = [
							'title' => 'Ticket',
							'url' => ['controller' => 'Tickets', 'action' => 'index'],
							'partialMatch' => true,
							'children' => [
								[
									'title' => 'Ticket Request',
									'url' => ['controller' => 'RequestTickets', 'action' => 'index'],
									'partialMatch' => true
								]
							]
						];
					}
					
					if ($user_module == 'TICKET-02') {
						$menu['menu-top'][] = [
							'title' => 'User Management',
							'url' => ['controller' => 'Users', 'action' => 'index'],
							'partialMatch' => true
						];
					}
					
					if ($user_module == 'TICKET-03') {
						$menu['menu-top'][] = [
							'title' => 'Profile',
							'url' => ['controller' => 'Profile', 'action' => 'index'],
							'partialMatch' => true
						];
					}
					
					if ($user_module == 'TICKET-11') {
						$menu_settings['children'][] = [
							'title' => 'Ticket Priorities',
							'url' => ['controller' => 'TicketPriorities', 'action' => 'index']
						];
					}
					
					if ($user_module == 'TICKET-12') {
						$menu_settings['children'][] = [
							'title' => 'Ticket Categories',
							'url' => ['controller' => 'TicketCategories', 'action' => 'index']
						];
					}
					
					if ($user_module == 'TICKET-13') {
						$menu_settings['children'][] = [
							'title' => 'Departments',
							'url' => ['controller' => 'Departments', 'action' => 'index']
						];
					}
					
					if ($user_module == 'TICKET-14') {
						$menu_settings['children'][] = [
							'title' => 'Product Type',
							'url' => ['controller' => 'ProductType', 'action' => 'index']
						];
					}
					
					if ($user_module == 'TICKET-15') {
						$menu_settings['children'][] = [
							'title' => 'Products',
							'url' => ['controller' => 'Products', 'action' => 'index']
						];
					}
					
					if ($user_module == 'TICKET-16') {
						$menu_settings['children'][] = [
							'title' => 'Spare Parts',
							'url' => ['controller' => 'SpareParts', 'action' => 'index']
						];
					}
					
					if ($user_module == 'TICKET-17') {
						$menu_settings['children'][] = [
							'title' => 'Damages',
							'url' => ['controller' => 'Damages', 'action' => 'index']
						];
					}
					
					if ($user_module == 'TICKET-18') {
						$menu_settings['children'][] = [
							'title' => 'Repairs',
							'url' => ['controller' => 'Repairs', 'action' => 'index']
						];
					}
					
					if ($user_module == 'TICKET-19') {
						$menu_settings['children'][] = [
							'title' => 'Repair Statuses',
							'url' => ['controller' => 'RepairStatuses', 'action' => 'index']
						];
					}
					
					if ($user_module == 'TICKET-20') {
						$menu_settings['children'][] = [
							'title' => 'Install Locations',
							'url' => ['controller' => 'InstallLocations', 'action' => 'index']
						];
					}
					
					if ($user_module == 'TICKET-21') {
						$menu_settings['children'][] = [
							'title' => 'Customer Types',
							'url' => ['controller' => 'CustomerTypes', 'action' => 'index']
						];
					}
					
					if ($user_module == 'TICKET-22') {
						$menu_settings['children'][] = [
							'title' => 'Company Types',
							'url' => ['controller' => 'CompanyTypes', 'action' => 'index']
						];
					}
					/**
					if ($user_module == 'TICKET-23') {
						$menu_settings['children'][] = [
							'title' => 'Holidays',
							'url' => ['controller' => 'Holidays', 'action' => 'index']
						];
					}
					*/
					if ($user_module == 'TICKET-24') {
						$menu_settings['children'][] = [
							'title' => 'Ticket Subcategories',
							'url' => ['controller' => 'TicketSubcategories', 'action' => 'index']
						];
					}
					/**
					if ($user_module == 'TICKET-25') {
						$menu['menu-top'][] = [
							'title' => 'User Manual',
							'url' => ['controller' => 'Manual', 'action' => 'index'],
							'partialMatch' => true
						];
					}
                    */
				}

				$this->request->session()->write('Auth.User.module_codes', $module_codes);
			}
			
			if (!empty($menu_settings)) {
				$menu['menu-top'][] = $menu_settings;
			}
		
			$this->request->session()->write('Auth.User.menu', $menu);
		}
		
		$menu = $this->request->session()->read('Auth.User.menu');
		
		return $menu;
	}	
}