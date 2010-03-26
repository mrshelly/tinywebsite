<?php
	/* By shelly<mrshelly@hotmail.com> 2008-10 */

	//系统统一入口
	if (! defined("IN_SYS")) define('IN_SYS', true);

	/* 获基本 系统GET变量 */
		$outType=isset($_GET['o'])?trim($_GET['o']):'';
		$mod=isset($_GET['mod'])?trim($_GET['mod']):'default';

	/* 初始化 */
		chdir("./");
		$rootPath=".";
		require_once $rootPath."/cfg/config.php";
		require_once $rootPath."/init.php";

	/* 调用 */
		switch($mod){
			case	"api"		:
				$apiMod=isset($_GET['api'])?trim($_GET['api']):'';
				if (!in_array($apiMod, $siteCfg['index']['mod']['api'])){
					exit($retOut(array('ret'=>'err', 'msg'=>'api part error!')));
				}
				if(!file_exists($rootPath."/api/".$apiMod.".php")){
					exit($retOut(array('ret'=>'err', 'msg'=>'api part error!')));
				}
				require $rootPath."/api/".$apiMod.".php";
				break;
			case	"act"		:
				$actMod=isset($_GET['act'])?trim($_GET['act']):'';
				if (!in_array($actMod, $siteCfg['index']['mod']['act'])){
					exit($retOut(array('ret'=>'err', 'msg'=>'act part error1!')));
				}
				if(!file_exists($rootPath."/act/".$actMod.".php")){
					exit($retOut(array('ret'=>'err', 'msg'=>'act part error2!')));
				}
				require $rootPath."/act/".$actMod.".php";
				break;
			case	"sys"		:
				$sysMod=isset($_GET['sys'])?trim($_GET['sys']):'default';
				if(!file_exists($rootPath."/".$sysMod.".php")){
					exit($retOut(array('ret'=>'err', 'msg'=>" {$sysMod} part error!")));
				}
				require $rootPath."/".$sysMod.".php";
				break;
			default	:
				require $rootPath."/default.php";
		}

?>