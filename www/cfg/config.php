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
				'dir'=>array(
					'ent_news'=>array(
						'name'=>'企业新闻',
						'url'=>'/?mod=sys&sys=news&ntype=ent',
					),
					'spc_news'=>array(
						'name'=>'业界新闻',
						'url'=>'/?mod=sys&sys=news&ntype=spc',
					),
				),
				'url'=>'/?mod=sys&sys=news',
			),
			'product'=>array(
				'name'=>'公司产品',
				'url'=>'/?mod=sys&sys=products',
				'dir'=>array(
					'proser1'=>array(
						'name'=>'系列1',
						'url'=>'/?mod=sys&sys=products&pser=1',
						'dir'=>array(
							'prospec1'=>array(
								'name'=>'规格1',
								'url'=>'/?mod=sys&sys=products&pser=1&pspec=1',
							),
							'prospec2'=>array(
								'name'=>'规格2',
								'url'=>'/?mod=sys&sys=products&pser=1&pspec=2',
							),
							'prospec3'=>array(
								'name'=>'规格3',
								'url'=>'/?mod=sys&sys=products&pser=1&pspec=3',
							),
							'prospec4'=>array(
								'name'=>'规格4',
								'url'=>'/?mod=sys&sys=products&pser=1&pspec=4',
							),
						),
					),
					'proser2'=>array(
						'name'=>'系列2',
						'url'=>'/?mod=sys&sys=products&pser=2',
						'dir'=>array(
							'prospec1'=>array(
								'name'=>'规格1',
								'url'=>'/?mod=sys&sys=products&pser=2&pspec=1',
							),
							'prospec2'=>array(
								'name'=>'规格2',
								'url'=>'/?mod=sys&sys=products&pser=2&pspec=2',
							),
						),
					),
					'proser3'=>array(
						'name'=>'系列3',
						'url'=>'/?mod=sys&sys=products&pser=3',
					),
					'proser4'=>array(
						'name'=>'系列4',
						'url'=>'/?mod=sys&sys=products&pser=4',
					),
				),
			),
			'gbook'=>array(
				'name'=>'联系我们',
				'url'=>'/?mod=sys&sys=gbook',
				'dir'=>array(
					'email'=>array(
						'name'=>'Email联系',
						'url'=>'/?mod=sys&sys=gbook&ctype=email',
					),
					'qq'=>array(
						'name'=>'QQ联系',
						'url'=>'/?mod=sys&sys=gbook&ctype=qq',
					),
					'other'=>array(
						'name'=>'其它联系',
						'url'=>'/?mod=sys&sys=gbook&ctype=other',
					),
				),
			),
			'sitemap'=>array(
				'name'=>'站点地图',
				'url'=>'/?mod=sys&sys=sitemap',
			),
		),
	);

?>