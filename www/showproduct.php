<?php
	/* By shelly<mrshelly@hotmail.com> 2008-10 */

	/* 动作处理不允许直接调用 */
		if (! defined("IN_SYS")) exit("Access Denied");

	// 分页设置

		$pp=isset($_GET['pp'])?intval($_GET['pp']):30;
		$p = isset($_GET['p'])?intval($_GET['p']):1;
		$start=($p-1)*$pp;

		$part = 'product';

	/* 初始化数据库实例 */
		$db = new PDO('sqlite:'.$siteCfg['dbset']['path'].'/'.$siteCfg['dbset']['db']); 
		$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);

	// 新闻ID
		$id = isset($_GET['id'])?intval($_GET['id']):0;
		if($id == 0){
			header("location: /?mod=sys&sys={$part}s");
			exit;
		}

		$outArray = array();

	// 取网站LOGO url
		$k = 'logo_url';
		$sql = "SELECT v FROM config WHERE k=:key LIMIT 1";
		$sth = $db->prepare($sql);
		$sth->execute(array('key'=>$k));
		$v = $sth->fetchAll();

		$outArray['logo_url'] = (is_array($v))?$v[0]['v']:'';

	// 取网站栏目
		$k = 'menu';
		$sql = "SELECT v FROM config WHERE k=:key LIMIT 1";
		$sth = $db->prepare($sql);
		$sth->execute(array('key'=>$k));
		$v = $sth->fetchAll();

		$outArray['menu'] = (is_array($v))?json_decode($v[0]['v'], true):array();

	// 取产品
		$k = "{$id}";
		$sql = "SELECT id, name, img, content, crts FROM {$part} WHERE id=:id LIMIT 1";
		$sth = $db->prepare($sql);
		$sth->execute(array(':id'=>$k));
		$v = $sth->fetchAll();

		$outArray[$part] = (is_array($v))?$v[0]:array();


/* 组织SQL语句 */

		require_once $rootPath."/tpl/show{$part}.php";

	// 关闭数据库连接
		//$db->close();

		exit;
?>