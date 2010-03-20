<?php
class Token{
	var $_pubKey = 'voip.mrshelly.com';
	var $_time = 0;

	function __destruct(){
		unset($this->_pubKey);
	}

	function __construct($cfg=array()){
		if(in_array('pubkey', array_keys($cfg))){
			$this->_pubKey = $cfg['pubkey'];
		}else{
			$this->_pubKey = 'voip.mrshelly.com';
		}

		if(in_array('time', array_keys($cfg))){
			$this->_time = $cfg['time'];
		}else{
			$this->_time = time();
		}
	}

	function get(){

	}

}

		function decodeAuth($v, $pkey){
			$len = strlen(base64_decode($v));
			$xorstr = str_pad($pkey, $len, $pkey);
			$v = base64_decode($v) ^ $xorstr;
			return json_decode(base64_decode($v),true);
		}

		function encodeAuth($v, $pkey){
			$v = base64_encode(json_encode($v));
			$len = strlen($v);
			$xorstr = str_pad($pkey, $len, $pkey);
			$v = $v ^ $xorstr;
			return base64_encode($v);
		}

?>
