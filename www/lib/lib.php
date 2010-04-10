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

// getNodeMenuHTML 生成菜单HTML
function getNodeMenuHTML($menucfg, $node, $level=1){
	if(empty($node)){
		return '';
	}

	$indent = str_repeat("\t", $level);
	$ret = '';

	if(in_array('url', array_keys($menucfg[$node]))){
		if(in_array('dir', array_keys($menucfg[$node]))){
			$ret .= $indent."\t".'<li><a href="'.$menucfg[$node]['url'].'" class="dir">'.$menucfg[$node]['name']."</a>\n";
			$ret .= $indent."\t\t<ul>\n";

			foreach($menucfg[$node]['dir'] as $k=>$v){
				$ret .= getNodeMenuHTML($menucfg[$node]['dir'], $k, $level+1);
			}
			$ret .= $indent."\t\t</ul>\n";
			$ret .= $indent."\t</li>\n";
		}else{
			$ret .= $indent."\t".'<li><a href="'.$menucfg[$node]['url'].'">'.$menucfg[$node]['name']."</a></li>\n";
		}
	}else{
		if(in_array('dir', array_keys($menucfg[$node]))){
			$ret .= $indent."\t".'<li><span class="dir">'.$menucfg[$node]['name']."</span>\n";
			$ret .= $indent."\t\t<ul>\n";

			foreach($menucfg[$node]['dir'] as $k=>$v){
				$ret .= getNodeMenuHTML($menucfg[$node]['dir'], $k, $level+1);
			}
			$ret .= $indent."\t\t</ul>\n";
			$ret .= $indent."\t</li>\n";
		}else{
			$ret .= $indent."\t".'<li><span>'.$menucfg[$node]['name']."</span></li>\n";
		}
	}
	return $ret;
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
