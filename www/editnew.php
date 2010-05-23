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
	if(!file_exists($siteCfg['dbset']['path'].'/'.$siteCfg['dbset']['db'])){
		header("location: /?mod=sys&sys=admin");
		exit;
	}else{
		$db = new PDO('sqlite:'.$siteCfg['dbset']['path'].'/'.$siteCfg['dbset']['db']); 
		$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
	}

	//
		$ref=isset($_GET['ref'])?trim($_GET['ref']):'/?mod=sys&sys=news';

	// 新闻ID
		$newid = isset($_GET['id'])?intval($_GET['id']):0;
		if($newid == 0){
			header("location: /?mod=sys&sys=news");
			exit;
		}

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

	// 检查登陆
		$authInfo = (isset($_COOKIE['auth']))?urldecode(trim($_COOKIE['auth'])):'';
		if($authInfo == ''){
			header('location: /?mod=sys&sys=login');
			exit;
		}else{
			$authInfo = decodeAuth($authInfo, $siteCfg['admin_pkey']);
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


	// 取新闻
		$k = "{$newid}";
		$sql = "SELECT id, title, content, crts FROM news WHERE id=:id LIMIT 1";
		$sth = $db->prepare($sql);
		$sth->execute(array(':id'=>$k));
		$v = $sth->fetchAll();

		$outArray['new'] = (is_array($v))?$v[0]:array();

	// 取新闻类别信息
		$sql = 'SELECT newid, cateid FROM rel_new_cate WHERE newid=:id GROUP BY cateid';
		$sth = $db->prepare($sql);
		$sth->execute(array(':id'=>$newid));
		$v = $sth->fetchAll();

		$v = (is_array($v))?$v:array();

		$catepid = 0;
		$cateInfo[$catepid] = array('id'=>0,'catename'=>'root', 'pid'=>0);
		$cateids = array();
		$cateInfo = array();
		foreach($v as $vv){
			$cateids[] = intval($vv['cateid']);
			$cateInfo[$vv['cateid']] = array();
		}

	// 当前分类设置
		if(count($cateids)>0){
			$sql = 'SELECT id, catename, pid FROM news_cate WHERE id IN ('.implode(", ", $cateids).') GROUP BY id';
			$sth = $db->prepare($sql);
			$sth->execute();
			$v = $sth->fetchAll();

			$v = (is_array($v))?$v:array();

			foreach($v as $vv){
				$catepid = (intval($vv['pid'])>0)?intval($vv['pid']):0;
				$cateInfo[$vv['id']] = $vv;
			}
		}

			$sql = 'SELECT id, catename, pid FROM news_cate WHERE id = :id';
			$sth = $db->prepare($sql);
			$sth->execute(array(':id'=>$catepid));
			$v = $sth->fetchAll();

			$v = (is_array($v))?$v[0]:false;
			if(is_array($v)){
				$cateInfo[$v['id']] = $v;
			}

/* 组织SQL语句 */

		require_once $rootPath."/tpl/editnew.php";


	// 关闭数据库连接
		//$db->close();

		exit;
?>