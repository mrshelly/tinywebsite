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

	// 参数
		$cateid = isset($_GET['id'])?intval($_GET['id']):0;

		$outArray = array();

	// 获取类别信息

		// 取请求类别信息
			$sql = 'SELECT id, catename, pid FROM news_cate WHERE id=:id';
			$sth = $db->prepare($sql);
			$sth->execute(array(':id'=>$cateid));
			$v = $sth->fetchAll();

			$curcate = (is_array($v) && count($v)>0)?$v[0]:array('id'=>0,'catename'=>'root', 'pid'=>0);

			if(false === $curcate){
				exit($retOut(array('ret'=>'err', 'msg'=>'id 参数有误!')));
			}

		// 获取父级类别信息
			$reqid = intval($curcate['pid']);
			$parentInfo = array();

			while($reqid >0){
				$sql = 'SELECT id, catename, pid FROM news_cate WHERE id=:id';
				$sth = $db->prepare($sql);
				$sth->execute(array(':id'=>$reqid));
				$v = $sth->fetchAll();

				$cate = (is_array($v) && count($v)>0)?$v[0]:array('id'=>0,'catename'=>'root', 'pid'=>0);

				if(is_array($cate)){
					$parentInfo[] = array(
						'id'=>$cate['id'],
						'catename'=>$cate['catename'],
						'pid'=>$cate['pid'],
					);

					$reqid = intval($cate['pid']);
				}else{
					$reqid = 0;
				}
			}
			$parentInfo[] = array('id'=>0,'catename'=>'root', 'pid'=>0);
			$parentInfo = array_reverse($parentInfo);

		// 获取下级类别信息
			$subInfo = array();
				$sql = 'SELECT id, catename, pid FROM news_cate WHERE pid=:id';
				$sth = $db->prepare($sql);
				$sth->execute(array(':id'=>$cateid));
				$v = $sth->fetchAll();

				$cate = (is_array($v))?$v:array();

				if(is_array($cate)){
					foreach($cate as $k=>$v){
						$subInfo[] = array(
							'id'=>$v['id'],
							'catename'=>$v['catename'],
							'pid'=>$v['pid'],
						);
					}
				}

			$retArray = array(
				'pinfo'=>$parentInfo,
				'cinfo'=>$curcate,
				'sinfo'=>$subInfo,
			);

			exit($retOut(array('ret'=>'ok', 'msg'=>'成功!', 'data'=>$retArray)));

	// 关闭数据库连接
		//$db->close();

		exit;
?>