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

		$admin_pkey = (is_array($v))?$v[0]['v']:'';
		if($admin_pkey == ''){
			exit($retOut(array('ret'=>'err', 'msg'=>'系统错误!')));
		}

	// 参数
		$data = isset($_POST['data'])?str_replace('\\','',trim($_POST['data'])):"";
		$data = json_decode($data,true);
		$data = is_array($data)?$data:array();

		if((!in_array('u', array_keys($data))) || (!in_array('p', array_keys($data)))){
			exit($retOut(array('ret'=>'err', 'msg'=>'参数错误!')));
		}

		$outArray = array();

	// 取网站后台用户
		$k = 'admin_user';
		$sql = "SELECT v FROM config WHERE k=:key LIMIT 1";
		$sth = $db->prepare($sql);
		$sth->execute(array('key'=>$k));
		$v = $sth->fetchAll();

		$outArray['admin_user'] = (is_array($v))?$v[0]['v']:'';

		if( trim($data['u']) != $outArray['admin_user']){
			exit($retOut(array('ret'=>'err', 'msg'=>'参数错误!u')));
		}

	// 取网站后台密码
		$k = 'admin_pass';
		$sql = "SELECT v FROM config WHERE k=:key LIMIT 1";
		$sth = $db->prepare($sql);
		$sth->execute(array('key'=>$k));
		$v = $sth->fetchAll();

		$outArray['admin_pass'] = (is_array($v))?json_decode($v[0]['v'], true):array();

		if( trim($data['p']) != $outArray['admin_pass']){
			exit($retOut(array('ret'=>'err', 'msg'=>'参数错误!p')));
		}

	// 创建登陆
		$authInfo = encodeAuth(array('uid'=>trim($data['u']), 'upass'=>trim($data['p'])), $siteCfg['admin_pkey']);

		setcookie('auth', urlencode($authInfo), time()+2*3600);
		exit($retOut(array('ret'=>'ok', 'msg'=>'成功')));

	// 关闭数据库连接
		//$db->close();

		exit;
?>