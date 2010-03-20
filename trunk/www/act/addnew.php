<?php
	/* By shelly<mrshelly@hotmail.com> 2008-10 */

	/* 动作处理不允许直接调用 */
		if (! defined("IN_SYS")) exit("Access Denied");

	// 分页设置

		$pp=isset($_GET['pp'])?intval($_GET['pp']):30;
		$p = isset($_GET['p'])?intval($_GET['p']):1;
		$start=($p-1)*$pp;

	// 身份认证
		require_once $rootPath."/lib/lib.php";

	/* 初始化数据库实例 */
		$db = new PDO('sqlite:'.$siteCfg['dbset']['path'].'/'.$siteCfg['dbset']['db']); 

	// 取网站公钥
		$k = 'admin_pkey';
		$sql = "SELECT v FROM config WHERE k=:key LIMIT 1";
		$sth = $db->prepare($sql);
		$sth->execute(array('key'=>$k));
		$v = $sth->fetchAll();

		$admin_pkey = (is_array($v))?$v[0][0]:'';
		if($admin_pkey == ''){
			exit($retOut(array('ret'=>'err', 'msg'=>'系统错误!')));
		}

	// 检查登陆
		$authInfo = (isset($_COOKIE['auth']))?urldecode(trim($_COOKIE['auth'])):'';
		if($authInfo == ''){
			exit($retOut(array('ret'=>'err', 'msg'=>'请登陆!')));
		}else{
			$authInfo = decodeAuth($authInfo, $siteCfg['admin_pkey']);
		}


		if((!is_array($authInfo)) || (!in_array('uid', array_keys($authInfo))) || (!in_array('upass', array_keys($authInfo)))){
			exit($retOut(array('ret'=>'err', 'msg'=>'请登陆!')));
		}


		if(($authInfo['uid'] != $siteCfg['admin_user']) || ($authInfo['upass'] != $siteCfg['admin_pass'])){
			exit($retOut(array('ret'=>'err', 'msg'=>'请登陆!')));
		}

	// 参数
		$data = isset($_POST['data'])?str_replace('\\','',trim($_POST['data'])):"";
		$data = json_decode($data,true);
		$data = is_array($data)?$data:array();

		if((!in_array('t', array_keys($data))) || (!in_array('c', array_keys($data)))){
			exit($retOut(array('ret'=>'err', 'msg'=>'参数错误!')));
		}

		$outArray = array();

	// 取新闻数据

		if(trim($data['t']) == ''){
			exit($retOut(array('ret'=>'err', 'msg'=>'标题不能为空!')));
		}
		if(trim($data['c']) == ''){
			exit($retOut(array('ret'=>'err', 'msg'=>'新闻内容不能为空!')));
		}

		$sql = "INSERT INTO news (title, content, crts) VALUES (:title, :content, :crts)";

		$sth = $db->prepare($sql);
		$ret = $sth->execute(array(':title'=>$data['t'], ':content'=>$data['c'], ':crts'=>time()));

		exit($retOut(array('ret'=>'ok', 'msg'=>'成功', 'debug'=>'')));

	// 关闭数据库连接
		//$db->close();

		exit;
?>