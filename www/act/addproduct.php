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
		$sth->execute(array(':key'=>$k));
		$v = $sth->fetchAll();

		$admin_pkey = (is_array($v))?$v[0]['v']:'';
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

		if((!isset($_POST['n'])) || (!isset($_POST['c']))){
			exit($retOut(array('ret'=>'err', 'msg'=>'参数错误!')));
		}
		$data = array(
			'n'=>trim($_POST['n']),
			'c'=>trim($_POST['c']),
		);

		$outArray = array();

	// 取新闻数据

		if(trim($data['n']) == ''){
			exit($retOut(array('ret'=>'err', 'msg'=>'品名不能为空!')));
		}
		if(trim($data['c']) == ''){
			exit($retOut(array('ret'=>'err', 'msg'=>'描述不能为空!')));
		}

		$db->beginTransaction();
		$data['n'] = $db->quote($data['n']);
		$data['c'] = $db->quote(htmlspecialchars_decode(trim($data['c'])));
		$data['t'] = time();
		$sql = "INSERT INTO product (name, content, crts) VALUES (:name, :content, :crts)";

		$sth = $db->prepare($sql);
		$ret = $sth->execute(array(':name'=>$data['n'], ':content'=>$data['c'], ':crts'=>$data['t']));
		$retid = $db->lastInsertId();

		//$db->rollback();
		if($retid >0){
			$db->commit();
		}else{
			$db->rollback();
		}
		exit($retOut(array('ret'=>'ok', 'msg'=>'成功', 'data'=>array('id'=>$retid,), 'debug'=>'')));

	// 关闭数据库连接
		//$db->close();

		exit;
?>