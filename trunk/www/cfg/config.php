<?php
	/* By shelly<mrshelly@hotmail.com> 2008-10 */
	if (! defined("IN_SYS")) exit("Access Denied");

	$siteCfg = array(
		'dbset'=>array(
			'path'=>'./res/db',
			'db'=>'site.db',
		),
		'index'=>array(
			'mod'=>array(
				'api'=>array(
					'temp',												//测试用API模板
				),
				'act'=>array(
					'temp',												//测试用ACT模板
					'login',											//登陆
					'logout',											//退出登陆
					'addnew',											//添加新闻
					'delnew',											//删除新闻
					'editnew',											//修改新闻
					'addproduct',										//添加商品
				),
			),
		),
		'admin_user'=>'site_admin',										//后台用户
		'admin_pass'=>'Q@W#E$',											//后台密码
		'admin_pkey'=>'Q@W#E$',											//后台加密公钥
		'logo_url'=>'/res/img/logo.gif',								//首页LOGO
		'home_news_cnt'=>'6',											//首页显示新闻数
		'home_product_cnt'=>'2',										//首页显示产品数
		'menu'=>array(
			'home'=>array(
				'name'=>'首页',
				'url'=>'/',
			),
			'news'=>array(
				'name'=>'公司新闻',
				'url'=>'/?mod=sys&sys=news',
			),
			'product'=>array(
				'name'=>'公司产品',
				'url'=>'/?mod=sys&sys=product',
			),
			'gbook'=>array(
				'name'=>'联系我们',
				'url'=>'/?mod=sys&sys=gbook',
			),
			'sitemap'=>array(
				'name'=>'站点地图',
				'url'=>'/?mod=sys&sys=sitemap',
			),
		),
	);

?>