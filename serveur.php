<?php
echo ">>> serveur", PHP_EOL;

error_reporting(E_ALL);
set_time_limit(0);
ob_implicit_flush();

define('_R_', "\r");
define('_N_', "\n");

define('_RED_', 	"\033[91m");
define('_GREEN_', 	"\033[92m");
define('_YELLOW_', 	"\033[93m");
define('_BLUE_', 	"\033[34m");
define('_MAGENTA_', "\033[95m");
define('_CYAN_', 	"\033[96m");
define('_ENDCLR_', 	"\033[0m");


include 'addsock.php';
include 'detecto.php';


$libvar = new libvar();
$init = new initialiseur($libvar);
$init->start();




	
//var_dump($init);	
$th_addsock = new addsock($init,$libvar);
$th_detecto = new detecto($init,$libvar);

$th_addsock->start();
$th_detecto->start();


class libvar extends Volatile
{
	private $_adresse = '127.0.0.1';
	private $_port = 10000;
	
	public $socket;
	public $list_socket = array();
	public $list_error = array();
	public $list_msg = array();
	
    public function __construct(){ }
	
	public function set_list($val) { 
	$ct = count($this->list_socket); 
		$this->list_socket[ $ct ] = $val;
		return $ct; 
	}

	public function set_listmsg($val) { $this->list_msg = $val; }
	public function set_socket($val) { $this->socket = $val; return $this->socket; }
	public function set_error($val) { $this->list_error[ count($this->list_error) ] = $val; }
	
	public function unset_list($val) { unset($this->list_error[ $val ]); }

	public function get_socketinlist($val) { return $this->list_socket[$val]; }
	public function get_scklist() { return $this->list_socket; }
	public function get_adresse() { return $this->_adresse; }
	public function get_port() { return $this->_port; }
	public function get_socket() { return $this->socket; }
}
	
class initialiseur extends Worker   {
	
	private $_animat = [92,124,47,45];

	
	private $_active = false;
	private $_comand = null;
	private $_value;
	private $_libvar;
	


	
	
	

	
	public function __construct($libvar){
	  echo 'Start initialiseur' , PHP_EOL;
	  $this->_libvar = $libvar;
	  
	/* initialisation du socket serveur */
	 echo (  $this->_libvar->set_socket(socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false  ? 	
			'error socket : ' .  socket_strerror(socket_last_error()) : 
			( (socket_bind( $this->_libvar->get_socket(), $this->_libvar->get_adresse(), $this->_libvar->get_port())) == false ? 
				'error bind : ' . socket_strerror(socket_last_error($this->_libvar->get_socket())) :
				( (socket_listen($this->_libvar->get_socket(), 5)) == false ?
				'error listen : ' . socket_strerror(socket_last_error($this->_libvar->get_socket())) :
				'serveur start ok : ' . $this->_libvar->get_adresse() . ':' . $this->_libvar->get_port() )
			)
		) , PHP_EOL;
		
		
		
	}
	
	public function run(){
		$member_list_socket = array('test de tableau');
		$controle_list = array();
		while(true) { usleep(1000); //echo $this->animat();
			
			
			
			
			if($this->_active) { 
				switch($this->_comand) {
					case 'test': 
						$this->_libvar->set_list($member_list_socket); 
					break;

					
				}
				$this->_active = false;
			}
		}
	}
	

	
	public function controle($comand,$value=null) {
		
		while($this->_active) usleep(1000);

		$this->_value  = $value;
		$this->_comand = $comand;
		$this->_active = true;
	}
	private function animat() { return _RED_ . chr(next($this->_animat) ? current($this->_animat) : reset($this->_animat)) . _ENDCLR_ .  _R_; }
}



?>