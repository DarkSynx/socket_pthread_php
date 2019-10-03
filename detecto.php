<?php

/*
00: message
*/

class detecto extends Worker   {

private $_animat = [92,124,47,45];
private $_init;
private $_libvar;

public function __construct($init,$libvar){
  echo 'Start detect data client' , PHP_EOL;
  $this->_init = $init;
  $this->_libvar = $libvar;
  
}


public function run(){
	echo 'démarrage de detecto...', PHP_EOL;
	//var_dump( $this->_init );
	$listsock = array();
	$getsock = array();
	$getsocket = array();
	$list_count = 0;
	while(true){ usleep(1000); //echo chr(32),$this->animat();
		
			if( ($x = count($this->_libvar->get_scklist()) ) != $list_count) { $list_count = $x;
				$listsock = $this->_libvar->get_scklist();
			}
		
			foreach($listsock as $k => $l) {
				$getsock[$k] = socket_read($l, 2048, PHP_NORMAL_READ);
				
				/* code while to test and get end of data */ 
				
			}				
			$this->_libvar->set_listmsg(array_filter($getsock));
			var_dump($this->_libvar->list_msg);
			
			
	}
}

	private function get_rtn_myvalue() {
		while($this->_init->_return == null)usleep(1000); 
		return json_decode($this->_init->_return,true);
	}
	private function animat() {
			return _YELLOW_ . chr(next($this->_animat) ? current($this->_animat) : reset($this->_animat)) . _ENDCLR_ .  _R_;
	}


}


?>