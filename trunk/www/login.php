<?php
	/* By shelly<mrshelly@hotmail.com> 2008-10 */

	/* 动作处理不允许直接调用 */
		if (! defined("IN_SYS")) exit("Access Denied");

	// 身份认证
		require_once $rootPath."/lib/lib.php";

	// 分页设置

		$pp=isset($_GET['pp'])?intval($_GET['pp']):30;
		$p = isset($_GET['p'])?intval($_GET['p']):1;
		$start=($p-1)*$pp;

	/* 初始化数据库实例 */
		$db = new PDO('sqlite:'.$siteCfg['dbset']['path'].'/'.$siteCfg['dbset']['db']); 
		$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);

	//
		$ref=isset($_GET['ref'])?trim($_GET['ref']):'/?mod=sys&sys=admin';

	// 取网站公钥
		$k = 'admin_pkey';
		$sql = "SELECT v FROM config WHERE k=:key LIMIT 1";
		$sth = $db->prepare($sql);
		$sth->execute(array(':key'=>$k));
		$v = $sth->fetchAll();

		$admin_pkey = (is_array($v))?$v[0]['v']:'';
		if($admin_pkey == ''){
			exit("系统错误!");
		}

	// 检查登陆 已经登陆了,就不再登陆了.
		$authInfo = (isset($_COOKIE['auth']))?urldecode(trim($_COOKIE['auth'])):'';
		if($authInfo != ''){
			$authInfo = decodeAuth($authInfo, $siteCfg['admin_pkey']);
			if(($authInfo['uid'] == $siteCfg['admin_user']) && ($authInfo['upass'] == $siteCfg['admin_pass'])){
				header('location: /?mod=sys&sys=admin');
				exit;
			}

		}

		$outArray = array();

	// 取网站LOGO url
		$k = 'logo_url';
		$sql = "SELECT v FROM config WHERE k=:key LIMIT 1";
		$sth = $db->prepare($sql);
		$sth->execute(array(':key'=>$k));
		$v = $sth->fetchAll();

		$outArray['logo_url'] = (is_array($v))?$v[0]['v']:'';

	// 取网站栏目
		$k = 'menu';
		$sql = "SELECT v FROM config WHERE k=:key LIMIT 1";
		$sth = $db->prepare($sql);
		$sth->execute(array(':key'=>$k));
		$v = $sth->fetchAll();

		$outArray['menu'] = (is_array($v))?json_decode($v[0]['v'], true):array();


/* 组织SQL语句 */

		require_once $rootPath."/tpl/login.php";

	// 关闭数据库连接
		//$db->close();

		exit;
?>