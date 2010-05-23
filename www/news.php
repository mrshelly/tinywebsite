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
		$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);

		$outArray = array();

	// 取类别数据
		$cateid = isset($_GET['ncate'])?intval($_GET['ncate']):0;

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

		$authInfo = (isset($_COOKIE['auth']))?urldecode(trim($_COOKIE['auth'])):'';
		if($authInfo != ''){
			$authInfo = decodeAuth($authInfo, $siteCfg['admin_pkey']);
		}

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

	// 取新闻类别信息
		// 取请求类别信息
			$sql = 'SELECT id, catename, pid FROM news_cate WHERE id=:id';
			$sth = $db->prepare($sql);
			$sth->execute(array(':id'=>$cateid));
			$v = $sth->fetchAll();

			$curcate = (is_array($v))?$v[0]:false;

			if(false === $curcate){
				exit($retOut(array('ret'=>'err', 'msg'=>'id 参数有误!')));
			}

		// 取子类别过滤条件
			$reqid = ($cateid>0)?array(intval($curcate['id'])):array();

			$filterids = ($cateid>0)?array($reqid[0]):array();

			$fstr = "pid={$reqid[0]}";
			while(count($reqid) >0){
				$sql = "SELECT id, catename, pid FROM news_cate WHERE {$fstr}";

				$sth = $db->prepare($sql);
				$sth->execute();
				$v = $sth->fetchAll();
				$cate = (is_array($v))?$v:false;

				if(is_array($cate)){
					$reqid = array();
					foreach($cate as $k=>$v){
						$filterids[] = intval($v['id']);
						$reqid[] = intval($v['id']);
					}
					$fstr = array();
					foreach($reqid as $i){
						$fstr[] = "pid={$i}";
					}
					$fstr = implode(' OR ', $fstr);
				}else{
					$reqid = array();
					break;
				}
			}

			$filterString = (count($filterids)>0)?"cateid IN ('".implode("', '", $filterids)."')":' 1=1 ';

	// 取新闻
		$sql = "SELECT id, title, content, crts, cateid FROM news LEFT JOIN rel_new_cate r ON newid = id WHERE {$filterString} GROUP BY id ORDER BY id DESC LIMIT :p, :pp";
		$sth = $db->prepare($sql);

		$ret = $sth->execute(array(':p'=>$p-1, ':pp'=>$pp));
		$v = $sth->fetchAll();

		$outArray['news'] = (is_array($v))?$v:array();

/* 组织SQL语句 */

		require_once $rootPath."/tpl/news.php";

	// 关闭数据库连接
		//$db->close();

		exit;
?>