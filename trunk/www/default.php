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
		$ref=isset($_GET['ref'])?trim($_GET['ref']):'/';

	// 取网站公钥
		$k = 'admin_pkey';
		$sql = "SELECT v FROM config WHERE k=:key LIMIT 1";
		$sth = $db->prepare($sql);
		$sth->execute(array('key'=>$k));
		$v = $sth->fetchAll();

		$admin_pkey = (is_array($v))?$v[0]['v']:'';
		if($admin_pkey == ''){
			exit("系统错误!");
		}

	// 检查登陆
		$authInfo = (isset($_COOKIE['auth']))?urldecode(trim($_COOKIE['auth'])):'';
		if($authInfo == ''){
			$authInfo = false;
		}else{
			$authInfo = decodeAuth($authInfo, $siteCfg['admin_pkey']);
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


	// 取首页新闻数
		$k = 'home_news_cnt';
		$sql = "SELECT v FROM config WHERE k=:key LIMIT 1";
		$sth = $db->prepare($sql);
		$sth->execute(array('key'=>$k));
		$v = $sth->fetchAll();

		$outArray['home_news_cnt'] = (is_array($v))?intval($v[0]['v']):0;

	// 取首页新闻
		$k = 'home_news';
		$sql = "SELECT id, title, content, crts FROM news ORDER BY id DESC LIMIT {$outArray['home_news_cnt']}";
		$sth = $db->prepare($sql);
		$sth->execute();
		$v = $sth->fetchAll();

		$outArray['home_news'] = (is_array($v))?$v:array();

	// 取首页产品数
		$k = 'home_product_cnt';
		$sql = "SELECT v FROM config WHERE k=:key LIMIT 1";
		$sth = $db->prepare($sql);
		$sth->execute(array('key'=>$k));
		$v = $sth->fetchAll();

		$outArray['home_product_cnt'] = (is_array($v))?intval($v[0]['v']):0;

	// 取首页产品
		$k = 'home_product';
		$sql = "SELECT id, name, img, content, crts FROM product ORDER BY id DESC LIMIT {$outArray['home_product_cnt']}";
		$sth = $db->prepare($sql);
		$sth->execute();
		$v = $sth->fetchAll();

		$outArray['home_product'] = (is_array($v))?$v:array();

/* 组织SQL语句 */

		require_once $rootPath."/tpl/default.php";

	/* 创建表 */
		/*
		$sql = <<<EOT
CREATE TABLE details (
  id            integer PRIMARY KEY NOT NULL,
  op_type       varchar(45),
  order_id      varchar(12),
  order_client  varchar(100),
  ordertime     integer,
  product_id    integer,
  quanlity      float(10,4),
  amount        float(10,4),
  price         float(10,4),
  operator      varchar(50),
  others        varchar(150),
  other_memo    varchar(255)
);
EOT;

		echo $sql;
		var_dump($db->query($sql));

		$sql = <<<EOT
CREATE TABLE product (
  id         integer PRIMARY KEY NOT NULL,
  barcode    varchar(20),
  class      varchar(100),
  name       varchar(200),
  unit       varchar(50),
  price      float(10,4),
  quanlity   float(10,4),
  store_add  varchar(50),
  supplier   varchar(200),
  p_memo     varchar(255)
);
EOT;
		echo $sql;
		var_dump($db->query($sql));
		*/


	// 关闭数据库连接
		//$db->close();

		exit;
?>