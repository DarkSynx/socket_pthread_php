<?php

/*
00: message
*/

class addsock extends Worker   {

private $_animat = [92,124,47,45];
private $_init;
private $_libvar;

public function __construct($init,$libvar){
  echo 'Start add socket' , PHP_EOL;
  $this->_init = $init;
  $this->_libvar = $libvar;
  
}


public function run(){
	echo 'démarrage du addsock...', PHP_EOL;
	//var_dump( $this->_init );
	
	while(true){ usleep(1000); //echo chr(32),$this->animat();
  
		
		
		
		
		if ( $this->_libvar->get_socketinlist( ($rt = $this->_libvar->set_list( socket_accept($this->_libvar->get_socket()))) )[0] === false ) {
			$this->_libvar->set_error("socket_accept() a échoué : raison : " . socket_strerror(socket_last_error($sock)));
			
		} else {
			
			$msg = 'm:Bienvenu sur le serveur' . _N_;
			//var_dump($this->_libvar->get_socketinlist($rt));
			socket_write( $this->_libvar->get_socketinlist($rt)[0], $msg, strlen($msg));
			
		}
	
		
	}
}

	private function get_rtn_myvalue() {
		while($this->_init->_return == null)usleep(1000); 
		return json_decode($this->_init->_return,true);
	}
	private function animat() {
			return _GREEN_ . chr(next($this->_animat) ? current($this->_animat) : reset($this->_animat)) . _ENDCLR_ .  _R_;
	}


}


?>