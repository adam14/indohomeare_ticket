<?php
// Redis Cache Component using phpredis extension
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use ElephantIO\Client as Elephant;
use ElephantIO\Engine\SocketIO\Version1X;

class SocketIOComponent extends Component
{
	/**
	 *  emit method
	 *  emit data to socket.io
	 *  @param string $event, array $data, string $server, string $namespace
	 *  @return bool
	 */
	public function emit($event, $data = [], $server = null, $namespace = null)
	{
		if (is_array($data)) {
			$socket_server = (empty($server)) ? Configure::read('socket_io') : $server;
			
			if (!empty($socket_server)) {
				$parse = parse_url($socket_server);
				
				if (!array_key_exists('host', $parse) || !array_key_exists('port', $parse)) {
					return false;
				}
				
				$socket_host = $parse['host'];
				$socket_port = $parse['port'];
				
				$fp = @fsockopen($socket_host, $socket_port, $errno, $errstr, 1);
			
				if ($fp) {
					fclose($fp);
					
					$elephant = new Elephant(new Version1X($socket_server));
						
					try {
						$elephant->initialize();
						
						if (!empty($namespace)) {
							$elephant->of($namespace);
						}
						
						$elephant->emit($event, $data);						
						$elephant->close();
						
						return true;
					} catch (Exception $e) {
						return false;
					}
				}
			}			
		}
		
		return false;
	}
	
}
